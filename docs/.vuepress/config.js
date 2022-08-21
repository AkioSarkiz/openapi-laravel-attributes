module.exports = {
    base: '/laravel-openapi/',
    lang: 'en-US',
    title: 'Laravel Openapi',

    themeConfig: {
        logo: 'images/openapi-logo.png',

        navbar: [
            {
                text: 'Github',
                link: 'https://github.com/AkioSarkiz/openapi-laravel-attributes',
            },
        ],

        sidebar: [
            {
                text: 'Getting started',
                link: '/docs/',
                children: [
                    {
                        text: 'Installation',
                        link: '/installation',
                    },
                    {
                        text: 'Basic attributes',
                        link: '/basic-attributes',
                    },
                    {
                        text: 'Routes',
                        link: '/routes',
                    },
                    {
                        text: 'Schemas',
                        link: '/schemas',
                    },
                ],
            },
            {
                text: 'Transformers API',
                link: '/docs/transformers/',
                children: [
                    {
                        text: 'About transformers',
                        link: '/about',
                    },
                    {
                        text: 'AttributesOpenapiTransformer API',
                        link: '/attributes-openapi-transformer',
                    },
                    {
                        text: 'SortPathsTransformer API',
                        link: '/sort-paths-transformer',
                    },
                ],
            },
        ],
        displayAllHeaders: true,
        sidebarDepth: 2,
    },
};
