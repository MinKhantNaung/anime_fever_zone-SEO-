import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'sm:max-w-sm',
        'sm:max-w-md',

        'md:max-w-lg',
        'md:max-w-xl',

        'lg:max-w-2xl',
        'lg:max-w-3xl',

        'xl:max-w-4xl',
        'xl:max-w-5xl',

        '2xl:max-w-6xl',
        '2xl:max-w-7xl',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    "50": "#eff6ff",
                    "100": "#dbeafe",
                    "200": "#bfdbfe",
                    "300": "#93c5fd",
                    "400": "#60a5fa",
                    "500": "#3b82f6",
                    "600": "#2563eb",
                    "700": "#d122e3",
                    "800": "#9926f0",
                    "900": "#1e3a8a"
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, require("daisyui"), require('tailwind-scrollbar-hide')],
};
