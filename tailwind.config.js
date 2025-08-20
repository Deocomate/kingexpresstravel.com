import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Mulish', 'Arial', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                yellow: colors.yellow,
                amber: colors.amber,
            },
        },
    },

    plugins: [],
};
