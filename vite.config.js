import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/js/app.js',
                    'resources/js/user-management.js',
                    'resources/js/email-e-gov.js',
                    'resources/js/profile.js',
                    'resource/js/subdomain-forms.js',
                    'resource/js/app-creation.js',
                    'resource/js/compliant-forms.js',
                    ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
