import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', '"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#2563EB',
                    600: '#1D4ED8',
                    700: '#1E40AF',
                    800: '#1E3A8A',
                    900: '#172554',
                },
                success: {
                    100: '#D1FAE5',
                    500: '#10B981',
                    700: '#047857',
                },
                warning: {
                    100: '#FEF3C7',
                    500: '#F59E0B',
                    700: '#B45309',
                },
                danger: {
                    100: '#FEE2E2',
                    500: '#EF4444',
                    700: '#B91C1C',
                },
                info: {
                    100: '#EDE9FE',
                    500: '#8B5CF6',
                    700: '#6D28D9',
                },
                neutral: {
                    bg: '#F8FAFC',
                    surface: '#FFFFFF',
                    border: '#E2E8F0',
                    400: '#94A3B8',
                    500: '#64748B',
                    600: '#475569',
                    700: '#334155',
                    800: '#1E293B',
                    900: '#0F172A',
                }
            }
        },
    },
    plugins: [],
};
