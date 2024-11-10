<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    public int $login_stage = 1;

    public string $name = '';

    public string $password = '';

    public string $two_factor_code = '';

    private ?User $user = null;

    public function login()
    {
        $this->validate(
            [
                'name' => 'required',
                'password' => 'required|digits:4|numeric',
            ],
            [
                'name.required' => 'derf nöd leer si',
                'password.required' => 'derf nöd leer si',
                'password.digits' => 'mues vierstellig si',
                'password.numeric' => 'münd Zahle si',
            ]
        );
        $users = User::where('name', $this->name);

        if ($users->count() === 0) {
            $this->addError('name', 'Hesch öppis falsch igäh?');

            // sleep a random amount of time to prevent timing attacks
            sleep(random_int(1, 3));
        } else {
            foreach ($users->get() as $user) {
                if (Hash::check($this->password, $user->password)) {
                    $this->user = $user;
                }
            }

            // check if the user was found
            if ($this->user) {
                if ($this->login_stage === 1) {
                    $this->login_stage = 2;
                    $this->send_code();
                } elseif ($this->login_stage === 2) {
                    $this->login_stage_2();
                }
            } else {
                $this->addError('password', 'Hesch öppis falsch igäh?');

                // sleep a random amount of time to prevent timing attacks
                sleep(random_int(1, 3));
            }
        }
    }

    public
    function login_stage_2()
    {
        $this->validate(
            [
                'two_factor_code' => 'required|digits:6|numeric',
            ],
            [
                'two_factor_code.required' => 'derf nöd leer si',
                'two_factor_code.digits' => 'mues sechsstellig si',
                'two_factor_code.numeric' => 'münd Zahle si',
            ]
        );
        if ($this->user->isValidTwoFactorCode($this->two_factor_code)) {
            auth()->login($this->user, true);

            // refresh the page
            return redirect()->route('welcome');
        } else {
            $this->addError('two_factor_code', 'Hesch öppis falsch igäh?');

            // sleep a random amount of time to prevent timing attacks
            sleep(random_int(1, 3));
        }
    }

    public
    function send_code()
    {
        // send code
        if ($this->login_stage === 2 && $this->user) {
            $this->user->sendTwoFactorCode();
        }
    }
}

?>


<div class="text-left flex flex-col space-y-sm max-w-96 mx-auto pt-md">
    <flux:input
        wire:model="name"
        label="Diin Name"
        type="text"
        placeholder="zum Biispil 'Simon'"
    />
    <flux:input
        wire:model="password"
        label="Letschti vier Zahle vo dinere Natelnummere"
        type="text"
        placeholder="zum Biispil '1234'"
        mask="9999"
    />
    @if($login_stage === 2)
        <flux:input
            wire:model="two_factor_code"
            label="SMS Code"
            type="text"
            placeholder="zum Biispil '123456'"
            mask="999999"
        />
    @endif
    <flux:button wire:click="login" class="mt-md">Ilogge</flux:button>
</div>
