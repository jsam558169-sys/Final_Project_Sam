import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    navy: '#002147',
                    crimson: '#A6192E',
                },
                neutral: {
                    heading: '#050505',
                    body: '#495057',
                    bg: '#F8F9FA',
                    divider: '#DEE2E6',
                }
            },
            fontFamily: {
                // High-contrast Serif for headers
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                // Clean Sans-serif for body
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};