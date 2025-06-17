/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#14a9e3',
                'primary-light': '#42c5f5',
                'primary-dark': '#0e7db8',
            },
            fontFamily: {
                'nunito': ['Nunito', 'sans-serif'],
            },
            animation: {
                'bounce-slow': 'bounce 2s infinite',
                'wiggle': 'wiggle 1s ease-in-out infinite',
                'float': 'float 3s ease-in-out infinite',
                'slide-up': 'slideUp 0.6s ease-out forwards',
                'float-around': 'floatAround 15s infinite linear',
            },
            keyframes: {
                wiggle: {
                    '0%, 100%': { transform: 'rotate(0deg)' },
                    '25%': { transform: 'rotate(5deg)' },
                    '75%': { transform: 'rotate(-5deg)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '33%': { transform: 'translateY(-10px) rotate(5deg)' },
                    '66%': { transform: 'translateY(-5px) rotate(-3deg)' },
                },
                slideUp: {
                    'from': {
                        opacity: '0',
                        transform: 'translateY(30px)'
                    },
                    'to': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    }
                },
                floatAround: {
                    '0%': { transform: 'translateX(0) translateY(0) rotate(0deg)' },
                    '33%': { transform: 'translateX(30px) translateY(-30px) rotate(120deg)' },
                    '66%': { transform: 'translateX(-20px) translateY(20px) rotate(240deg)' },
                    '100%': { transform: 'translateX(0) translateY(0) rotate(360deg)' },
                }
            }
        },
    },
    plugins: [],
}
