import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
          '@': fileURLToPath(new URL('./resources/js', import.meta.url))
        }
      },
    css: {
        preprocessorOptions: {
          scss: {
            additionalData: `
              @import "@/assets/styles/mixins.scss";
              @import "@/assets/styles/vars.scss";
              @import "@/assets/styles/typography.scss";
            `
          }
        }
      }
});
