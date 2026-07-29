import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig } from 'vite-plus';

export default defineConfig({
    staged: {
        '*': 'vp check --fix',
    },
    lint: {
        plugins: ['eslint', 'typescript', 'unicorn', 'oxc', 'vue'],
        options: {
            typeAware: true,
            typeCheck: true,
        },
        ignorePatterns: [
            'vite.config.ts',
            'resources/js/components/ui/*',
            'resources/views/mail/*',
            'resources/js/actions/*',
            'resources/js/routes/*',
            'resources/js/wayfinder/*',
            'public',
        ],
    },
    fmt: {
        printWidth: 80,
        tabWidth: 4,
        useTabs: false,
        semi: true,
        singleQuote: true,
        overrides: [
            {
                files: ['**/*.yml', '**/*.yaml'],
                options: {
                    tabWidth: 2,
                },
            },
        ],
        sortTailwindcss: {
            functions: ['clsx', 'cn', 'cva'],
            stylesheet: 'resources/css/app.css',
        },
        sortImports: {
            groups: [
                'builtin',
                'external',
                'internal',
                'parent',
                'sibling',
                'index',
            ],
            newlinesBetween: false,
        },
        ignorePatterns: [
            'resources/js/components/ui/*',
            'resources/views/mail/*',
            'resources/js/actions/*',
            'resources/js/routes/*',
            'resources/js/wayfinder/*',
            'public',
            '.agents/skills/*',
            '.claude/skills/*',
            'AGENTS.md',
            'CLAUDE.md',
            'boost.json',
            'opencode.json',
            '.mcp.json',
        ],
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        inertia(),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ],
});
