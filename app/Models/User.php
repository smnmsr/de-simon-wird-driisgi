<?php

namespace App\Models;

use App\Notifications\Send2FaCode;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'two_factor_valid_until' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send 2FA code to the user.
     */
    public function sendTwoFactorCode(): void
    {
        // random 6 digit code
        $twoFactorCode = random_int(100000, 999999);

        // store the code in the user's model
        $this->two_factor_secret = sprintf('%06d', $twoFactorCode);
        $this->two_factor_valid_until = now()->addMinutes(5);
        $this->save();

        // send the code to the user
        $this->notify(new Send2FaCode($twoFactorCode));
    }

    /**
     * Check if the 2FA code is valid.
     */
    public function isValidTwoFactorCode(string $code): bool
    {
        // check if the code is too old
        if ($this->two_factor_valid_until->isPast()) {

            $this->two_factor_secret = null;
            $this->two_factor_valid_until = null;
            $this->save();
            return false;
        } elseif ($this->two_factor_secret == $code) {

            $this->two_factor_secret = null;
            $this->two_factor_valid_until = null;
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Route notifications for the Vonage channel.
     */
    public function routeNotificationForVonage($notification): string
    {
        return $this->phone_number;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {

            // remove all spaces from the phone number
            $user->phone_number = preg_replace('/\s+/', '', $user->phone_number);

            // make sure, the phone number starts with 0041, i.e. replace any start '07' with '00417'
            $user->phone_number = preg_replace('/^07/', '00417', $user->phone_number);

            $user->password = substr($user->phone_number, -4);
        });
    }
}
