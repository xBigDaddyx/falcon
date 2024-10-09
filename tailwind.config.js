/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
module.exports = {
    darkMode: 'class',
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#0C6478',
                    50: '#4ED0ED',
                    100: '#3CCBEB',
                    200: '#17C1E7',
                    300: '#13A2C2',
                    400: '#10839D',
                    500: '#0C6478',
                    600: '#073945',
                    700: '#020F12',
                    800: '#000000',
                    900: '#000000',
                    950: '#000000'
                },
                secondary: {
                    DEFAULT: '#82EE99',
                    50: '#FFFFFF',
                    100: '#FFFFFF',
                    200: '#EEFDF1',
                    300: '#CAF8D4',
                    400: '#A6F3B6',
                    500: '#82EE99',
                    600: '#51E771',
                    700: '#1FE148',
                    800: '#18B038',
                    900: '#117E28',
                    950: '#0E6621'
                },
                black: colors.black,
                white: colors.white,
                success: colors.emerald,
                info: colors.violet,
                warning: colors.amber,
                danger: colors.fuchsia,

            },
            gridTemplateRows: {
                '[auto,auto,1fr]': 'auto auto 1fr',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
    ],
}
