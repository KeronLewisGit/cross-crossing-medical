import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

// Fonts are downloaded at build time and served from /build, so visitors never hit a font CDN.
// Two families only: Lexend, designed for reading ease and close to the clean sans used on
// hospital wayfinding signs, for headings, sign plates and numerals; Mulish, a calm, open
// sans with generous x-height, for everything people read.
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Lexend', {
                    alias: 'display',
                    variable: '--ff-display',
                    weights: [400, 500, 600],
                    subsets: ['latin'],
                    preload: [{ weight: 600 }],
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                }),
                bunny('Mulish', {
                    alias: 'sans',
                    variable: '--ff-sans',
                    weights: [400, 600, 700, 800],
                    styles: ['normal'],
                    subsets: ['latin'],
                    preload: [{ weight: 400 }, { weight: 700 }],
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: { watch: { ignored: ['**/storage/framework/views/**'] } },
});
