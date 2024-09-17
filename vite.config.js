import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: {
        host: '0.0.0.0',  // Permitir acceso desde cualquier IP
        port: 8080,       // Cambiar el puerto si es necesario
    },
    resolve: {
        alias: {
            '@': '/resources/js',  // Crear alias para rutas JS
        },
    },
});