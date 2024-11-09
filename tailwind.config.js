import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "media",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        "./vendor/livewire/flux-pro/stubs/**/*.blade.php",
        "./vendor/livewire/flux/stubs/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Comic Sans MS', 'Comic Sans', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                xs: "0.75rem",
                sm: "1.5rem",
                md: "2.25rem",
                lg: "3rem"
            }
        },
    },
    plugins: [],
};
