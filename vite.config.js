import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/main.css',
            'resources/js/app.js',
        ]),
    ],
    build: {
        rollupOptions: {
            external: ['jquery'],
            output: {
                jquery: "$"
            }
        }
    }

});
