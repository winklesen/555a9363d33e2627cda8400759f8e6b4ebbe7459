import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';

// export default defineConfig({
//     server: {
//         host: '0.0.0.0',
//         port: 8502, // Ensure this matches the Vite port
//         hmr: {
//             host: '192.168.59.252',
//             port: 8502, // Use the same port for hot module replacement
//         },
//     },
//     plugins: [
//         laravel({
//             input: [
//                 'resources/sass/app.scss',
//                 'resources/js/app.js',
//                 'resources/css/app.css', // Add this CSS file
//             ],
//             refresh: true,
//         }),
//         react(),
//     ],
// });
