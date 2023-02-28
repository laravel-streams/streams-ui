module.exports = {
    content: [
        './resources/**/*.blade.php',
    ],
    safelist: [
        //'text-3xl',
        {
            pattern: /w-([0-9\/]+)/,
            variants: ['lg'],
        },
    ],
    theme: {
        extend: {
            // colors: {
            //     light: 'var(--ui-color-light)',
            //     dark: 'var(--ui-color-dark)',
            //     primary: 'var(--ui-color-primary)',
            //     secondary: 'var(--ui-color-secondary)',

            //     transparent: 'transparent',
            //     current: 'currentColor',

            //     black: 'var(--ui-color-black)',
            //     white: 'var(--ui-color-white)',
            //     gray: 'var(--ui-color-gray)',

            //     red: 'var(--ui-color-red)',
            //     yellow: 'var(--ui-color-yellow)',
            //     green: 'var(--ui-color-green)',
            //     blue: 'var(--ui-color-blue)',
            // }
        }
    },
    plugins: [],
}
