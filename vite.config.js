import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'public/css/login.css',
                'public/css/create-user.css',
                'public/css/welcome.css'
            ],
            refresh: true,
        }),
    ],
});
