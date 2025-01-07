import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'border' : {
                    light: '#CCC',
                    dark: '#333'
                },

                'primary': '#af63fa',
                'green': '#5DA93D', // #00a336
                'blue': '#009BEE', // #00a9fe
                'red': '#E02D2D', // #f43638
                'yellow': '#FFA10B' // #efa700
            },
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
