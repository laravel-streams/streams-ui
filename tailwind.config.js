const colors = require('tailwindcss/colors')

module.exports = {
    purge: [],
    presets: [],
    darkMode: false,
    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
        },
        colors: {
            
            light: 'var(--cp-color-light)',
            dark: 'var(--cp-color-dark)',
            primary: 'var(--cp-color-primary)',
            secondary: 'var(--cp-color-secondary)',

            transparent: 'transparent',
            current: 'currentColor',

            black: 'var(--cp-color-black)',
            white: 'var(--cp-color-white)',
            gray: 'var(--cp-color-gray)',

            red: 'var(--cp-color-red)',
            yellow: 'var(--cp-color-yellow)',
            green: 'var(--cp-color-green)',
            blue: 'var(--cp-color-blue)',
        },
        spacing: {
            px: '1px',
            0: '0px',
            0.5: 'calc(var(--cp-spacing)*0.125rem)',
            1: 'calc(var(--cp-spacing)*0.25rem)',
            1.5: 'calc(var(--cp-spacing)*0.375rem)',
            2: 'calc(var(--cp-spacing)*0.5rem)',
            2.5: 'calc(var(--cp-spacing)*0.625rem)',
            3: 'calc(var(--cp-spacing)*0.75rem)',
            3.5: 'calc(var(--cp-spacing)*0.875rem)',
            4: 'calc(var(--cp-spacing)*1rem)',
            5: 'calc(var(--cp-spacing)*1.25rem)',
            6: 'calc(var(--cp-spacing)*1.5rem)',
            7: 'calc(var(--cp-spacing)*1.75rem)',
            8: 'calc(var(--cp-spacing)*2rem)',
            9: 'calc(var(--cp-spacing)*2.25rem)',
            10: 'calc(var(--cp-spacing)*2.5rem)',
            11: 'calc(var(--cp-spacing)*2.75rem)',
            12: 'calc(var(--cp-spacing)*3rem)',
            14: 'calc(var(--cp-spacing)*3.5rem)',
            16: 'calc(var(--cp-spacing)*4rem)',
            20: 'calc(var(--cp-spacing)*5rem)',
            24: 'calc(var(--cp-spacing)*6rem)',
            28: 'calc(var(--cp-spacing)*7rem)',
            32: 'calc(var(--cp-spacing)*8rem)',
            36: 'calc(var(--cp-spacing)*9rem)',
            40: 'calc(var(--cp-spacing)*10rem)',
            44: 'calc(var(--cp-spacing)*11rem)',
            48: 'calc(var(--cp-spacing)*12rem)',
            52: 'calc(var(--cp-spacing)*13rem)',
            56: 'calc(var(--cp-spacing)*14rem)',
            60: 'calc(var(--cp-spacing)*15rem)',
            64: 'calc(var(--cp-spacing)*16rem)',
            72: 'calc(var(--cp-spacing)*18rem)',
            80: 'calc(var(--cp-spacing)*20rem)',
            96: 'calc(var(--cp-spacing)*24rem)',
        },
        backgroundColor: (theme) => theme('colors'),
        borderColor: (theme) => ({
            ...theme('colors'),
            DEFAULT: theme('colors.gray', 'currentColor'),
        }),
        borderRadius: {
            none: '0px',
            sm: 'calc(var(--cp-radius)*0.125rem)',
            DEFAULT: 'calc(var(--cp-radius)*0.25rem)',
            md: 'calc(var(--cp-radius)*0.375rem)',
            lg: 'calc(var(--cp-radius)*0.5rem)',
            xl: 'calc(var(--cp-radius)*0.75rem)',
            '2xl': 'calc(var(--cp-radius)*1rem)',
            '3xl': 'calc(var(--cp-radius)*1.5rem)',
            full: '9999px',
        },
        divideColor: (theme) => theme('borderColor'),
        divideOpacity: (theme) => theme('borderOpacity'),
        divideWidth: (theme) => theme('borderWidth'),
        fill: {
            current: 'currentColor'
        },
        fontFamily: {
            sans: [
                'ui-sans-serif',
                'system-ui',
                '-apple-system',
                'BlinkMacSystemFont',
                '"Segoe UI"',
                'Roboto',
                '"Helvetica Neue"',
                'Arial',
                '"Noto Sans"',
                'sans-serif',
                '"Apple Color Emoji"',
                '"Segoe UI Emoji"',
                '"Segoe UI Symbol"',
                '"Noto Color Emoji"',
            ],
            serif: ['ui-serif', 'Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif'],
            mono: [
                'ui-monospace',
                'SFMono-Regular',
                'Menlo',
                'Monaco',
                'Consolas',
                '"Liberation Mono"',
                '"Courier New"',
                'monospace',
            ],
        },
        fontSize: {
            xs: ['0.75rem', {
                lineHeight: '1rem'
            }],
            sm: ['0.875rem', {
                lineHeight: '1.25rem'
            }],
            base: ['1rem', {
                lineHeight: '1.5rem'
            }],
            lg: ['1.125rem', {
                lineHeight: '1.75rem'
            }],
            xl: ['1.25rem', {
                lineHeight: '1.75rem'
            }],
            '2xl': ['1.5rem', {
                lineHeight: '2rem'
            }],
            '3xl': ['1.875rem', {
                lineHeight: '2.25rem'
            }],
            '4xl': ['2.25rem', {
                lineHeight: '2.5rem'
            }],
            '5xl': ['3rem', {
                lineHeight: '1'
            }],
            '6xl': ['3.75rem', {
                lineHeight: '1'
            }],
            '7xl': ['4.5rem', {
                lineHeight: '1'
            }],
            '8xl': ['6rem', {
                lineHeight: '1'
            }],
            '9xl': ['8rem', {
                lineHeight: '1'
            }],
        },
        gap: (theme) => theme('spacing'),
        gradientColorStops: (theme) => theme('colors'),
        keyframes: {
            spin: {
                to: {
                    transform: 'rotate(360deg)',
                },
            },
            ping: {
                '75%, 100%': {
                    transform: 'scale(2)',
                    opacity: '0',
                },
            },
            pulse: {
                '50%': {
                    opacity: '.5',
                },
            },
            bounce: {
                '0%, 100%': {
                    transform: 'translateY(-25%)',
                    animationTimingFunction: 'cubic-bezier(0.8,0,1,1)',
                },
                '50%': {
                    transform: 'none',
                    animationTimingFunction: 'cubic-bezier(0,0,0.2,1)',
                },
            },
        },
        letterSpacing: {
            tighter: '-0.05em',
            tight: '-0.025em',
            normal: '0em',
            wide: '0.025em',
            wider: '0.05em',
            widest: '0.1em',
        },
        listStyleType: {
            none: 'none',
            disc: 'disc',
            decimal: 'decimal',
        },
        margin: (theme, {
            negative
        }) => ({
            auto: 'auto',
            ...theme('spacing'),
            ...negative(theme('spacing')),
        }),
        maxHeight: (theme) => ({
            ...theme('spacing'),
            full: '100%',
            screen: '100vh',
        }),
        maxWidth: (theme, {
            breakpoints
        }) => ({
            none: 'none',
            0: '0rem',
            xs: '20rem',
            sm: '24rem',
            md: '28rem',
            lg: '32rem',
            xl: '36rem',
            '2xl': '42rem',
            '3xl': '48rem',
            '4xl': '56rem',
            '5xl': '64rem',
            '6xl': '72rem',
            '7xl': '80rem',
            full: '100%',
            min: 'min-content',
            max: 'max-content',
            prose: '65ch',
            ...breakpoints(theme('screens')),
        }),
        opacity: {
            0: '0',
            5: '0.05',
            10: '0.1',
            20: '0.2',
            25: '0.25',
            30: '0.3',
            40: '0.4',
            50: '0.5',
            60: '0.6',
            70: '0.7',
            75: '0.75',
            80: '0.8',
            90: '0.9',
            95: '0.95',
            100: '1',
        },
        order: {
            first: '-9999',
            last: '9999',
            none: '0',
            1: '1',
            2: '2',
            3: '3',
            4: '4',
            5: '5',
            6: '6',
            7: '7',
            8: '8',
            9: '9',
            10: '10',
            11: '11',
            12: '12',
        },
        outline: {
            none: ['2px solid transparent', '2px'],
            white: ['2px dotted white', '2px'],
            black: ['2px dotted black', '2px'],
            primary: ['2px dotted var(--cp-color-primary)', '2px'],
        },
        placeholderColor: (theme) => theme('colors'),
        placeholderOpacity: (theme) => theme('opacity'),
        ringColor: (theme) => ({
            DEFAULT: theme('colors.primary', '#3b82f6'),
            ...theme('colors'),
        }),
        ringOffsetColor: (theme) => theme('colors'),
        ringOffsetWidth: {
            0: '0px',
            1: '1px',
            2: '2px',
            4: '4px',
            8: '8px',
        },
        ringOpacity: (theme) => ({
            DEFAULT: '0.5',
            ...theme('opacity'),
        }),
        ringWidth: {
            DEFAULT: '3px',
            0: '0px',
            1: '1px',
            2: '2px',
            4: '4px',
            8: '8px',
        },
        space: (theme, {
            negative
        }) => ({
            ...theme('spacing'),
            ...negative(theme('spacing')),
        }),
        stroke: {
            current: 'currentColor',
        },
        strokeWidth: {
            0: '0',
            1: '1',
            2: '2',
        },
        textColor: (theme) => theme('colors'),
        textOpacity: (theme) => theme('opacity'),
        translate: (theme, {
            negative
        }) => ({
            ...theme('spacing'),
            ...negative(theme('spacing')),
            '1/2': '50%',
            '1/3': '33.333333%',
            '2/3': '66.666667%',
            '1/4': '25%',
            '2/4': '50%',
            '3/4': '75%',
            full: '100%',
            '-1/2': '-50%',
            '-1/3': '-33.333333%',
            '-2/3': '-66.666667%',
            '-1/4': '-25%',
            '-2/4': '-50%',
            '-3/4': '-75%',
            '-full': '-100%',
        }),
        zIndex: {
            auto: 'auto',
            0: '0',
            10: '10',
            20: '20',
            30: '30',
            40: '40',
            50: '50',
        },
    },
    plugins: [],
}
