import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: 'vendor/xbigdaddyx/falcon',
            input: [
                'resources/css/falcon.css',
                'resources/js/falcon.js',
            ],
            refresh: true,
        }),
    ],

});
