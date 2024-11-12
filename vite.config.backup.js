import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const host = 'localhost';
export default defineConfig({
    plugins: [
        laravel({
            server: { https: true },
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: true, // This allows Vite to accept connections from outside the container
        hmr: {host},
        port: 5173, // The port Vite will run on
        strictPort: true, // If the port is already used, Vite will fail instead of picking another port
        watch: {
            usePolling: true, // This is needed to work well inside Docker
        },
    },
});
