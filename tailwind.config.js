// tailwind.config.js
module.exports = {
    future: {},
    purge: [],
    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            xxl: '1560px',
            xxxl: '2000px',
        },
        extend: {
            gridTemplateColumns: {
                '16': 'repeat(16, minmax(0, 1fr))',
            },
            gridColumn: {
                'span-13': 'span 13 / span 13',
                'span-14': 'span 14 / span 14',
                'span-15': 'span 15 / span 15',
                'span-16': 'span 16 / span 16',
            }
        },
    },
    variants: {},
    plugins: [
        require('@tailwindcss/form'),
    ],
}
