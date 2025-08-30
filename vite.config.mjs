import laravel from 'laravel-vite-plugin';
import { defineConfig, loadEnv } from 'vite';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig(({ command, mode }) => {
    const env = loadEnv(mode, process.cwd(), '')
    return {
        plugins: [
            laravel([
                'resources/js/app.js',
            ]),
            tailwindcss(),
        ],
        server: {
            open: env.APP_URL
        }
    }
});
