<?php

return [

    /*
     |------------------------------------------------------------------------
     | Scan paths.
     |------------------------------------------------------------------------
     |
     | These paths will be used to scan files. By default, this is your application directory.
     | But you can add custom directories.
     |
     */

    'scan_paths' => [
        app_path(),
    ],

    /*
     |------------------------------------------------------------------------
     | Save path.
     |------------------------------------------------------------------------
     |
     | The path where the open api documentation file will be saved.
     | Saving works through a local drive.
     |
     | {ext} - will be replace to format.
     |
     */

    'save_path' => 'openapi/openapi_docs.{ext}',

    /*
     |------------------------------------------------------------------------
     | Filesystem disk.
     |------------------------------------------------------------------------
     |
     | TODO
     |
     */

    'disk' => 'local',

    /*
     |------------------------------------------------------------------------
     | Format generated data.
     |------------------------------------------------------------------------
     |
     | supported: json, yaml.
     |
     */

    'format' => 'json',

    /*
     |------------------------------------------------------------------------
     | Transformers openapi schema.
     |------------------------------------------------------------------------
     |
     | TODO
     |
     */

    'transformers' => [
        \AkioSarkiz\Openapi\Transformers\AttributesOpenapiTransformer::class,
        \AkioSarkiz\Openapi\Transformers\VariablesParseTransformer::class,
        \AkioSarkiz\Openapi\Transformers\SortPathsTransformer::class,
    ],

    /*
     |------------------------------------------------------------------------
     | Custom attributes.
     |------------------------------------------------------------------------
     |
     | Custom transform attributes. Used in \AkioSarkiz\Openapi\Transformers\LaravelOpenapiTransformer::class.
     | Adapter MUST be implementing \AkioSarkiz\Openapi\Contacts\AttributeAdapter::class.
     |
     */

    'custom_attributes' => [
        // Attribute::class => Adapter::class,
    ],

    /*
     |------------------------------------------------------------------------
     | Custom priority.
     |------------------------------------------------------------------------
     |
     | Custom sort property. Used in \AkioSarkiz\Openapi\Transformers\SortPathsTransformer::class.
     |
     */

    'custom_priority' => [
        // Default list:
        // 'GET', 'HEAD', 'POST', 'PATCH', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE'.
    ],


    /*
     |------------------------------------------------------------------------
     | Custom variables.
     |------------------------------------------------------------------------
     |
     | Custom sort property. Used in \AkioSarkiz\Openapi\Transformers\VariablesParseTransformer::class.
     |
     | Supported: integer, string, float, \Closure.
     |
     */

    'variables' => [
        // 'key' => 'value',
    ],

    /*
     |------------------------------------------------------------------------
     | Map type-parameter.
     |------------------------------------------------------------------------
     |
     | Used in \AkioSarkiz\Openapi\Transformers\AttributesOpenapiTransformer.
     |
     */

    'map_type_parameter' => [
        // 'slug' => 'string',
    ],

    /*
     |------------------------------------------------------------------------
     | Map middleware-security.
     |------------------------------------------------------------------------
     |
     | Used in \AkioSarkiz\Openapi\Transformers\AttributesOpenapiTransformer.
     |
     | Map middleware to security. You can define class name or alias of middleware
     | to security policy.
     |
     */

    'map_middleware_security' => [
        // 'auth:api' => 'api_auth',
    ],
];
