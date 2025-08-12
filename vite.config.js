import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import liveReload from 'vite-plugin-live-reload'
export default defineConfig({
    base: '/',
    plugins: [
        tailwindcss(),
        liveReload(['/(modules|config|views|widgets)/**/*.php'])
    ],
    build: {
        // generate manifest.json in outDir
        manifest: 'manifest.json',
        // output dir for production build
        outDir: './web/resources/dist/',
        rollupOptions: {
            input: './resources/main.js',
            output: {
                // Replace splitVendorChunkPlugin with manualChunks on Vite 7+
                manualChunks: (id) => {
                    if (id.includes('node_modules')) {
                        return 'vendor'
                    }
                }
            }
        }
    },
    server: {
        // we need a strict port to match on PHP side
        // change freely, but update on PHP to match the same port
        // tip: choose a different port per project to run them at the same time
        strictPort: true,
        port: 5173
    }
})