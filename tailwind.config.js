/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            },
            colors: {
                // UPR Brand Colors
                navy: {
                    50: '#e6ecf2',
                    100: '#b3c4d9',
                    200: '#809cbf',
                    300: '#4d74a6',
                    400: '#1a4d8c',
                    500: '#003366',
                    600: '#002d5c',
                    700: '#002652',
                    800: '#001f47',
                    900: '#00193d',
                    950: '#001233',
                },
                gold: {
                    50: '#fff9e0',
                    100: '#fff0b3',
                    200: '#ffe680',
                    300: '#ffdd4d',
                    400: '#ffd31a',
                    500: '#FFCC00',
                    600: '#e6b800',
                    700: '#cca300',
                    800: '#b38f00',
                    900: '#997a00',
                    950: '#806600',
                },
                success: {
                    50: '#e8f5ea',
                    100: '#c8e6c9',
                    200: '#a5d6a7',
                    300: '#81c784',
                    400: '#66bb6a',
                    500: '#28A745',
                    600: '#239a3e',
                    700: '#1e8c36',
                    800: '#197d2f',
                    900: '#146f27',
                },
                danger: {
                    50: '#fce8ea',
                    100: '#f5c6cb',
                    200: '#f1aeb5',
                    300: '#ea868f',
                    400: '#e35d6a',
                    500: '#DC3545',
                    600: '#c6303e',
                    700: '#b02a37',
                    800: '#9a2530',
                    900: '#842029',
                },
            },
        },
    },
    safelist: [
        // Status badge colors used dynamically in Blade templates
        { pattern: /bg-(amber|emerald|rose|sky|slate|navy|gold|success|danger)-(50|100|200|400|500|600|700)/ },
        { pattern: /text-(amber|emerald|rose|sky|slate|navy|gold|success|danger)-(50|100|200|400|500|600|700|800)/ },
        { pattern: /border-(amber|emerald|rose|sky|slate|navy|gold|success|danger)-(100|200|400|500)/ },
        { pattern: /shadow-(navy|gold|success|danger)-(500)\/\d+/ },
        { pattern: /from-(navy|gold)-(400|500|600|700)/ },
        { pattern: /to-(navy|gold)-(400|500|600|700|800)/ },
        { pattern: /via-(navy|gold)-(500|600)/ },
    ],
    plugins: [],
};
