#### Define servers

```php
#[
    Server('same server1', 'https//example.com'),
    Server('same server2', 'https//example.org'),
]
class BaseController 
{
    //
}
```

#### Define info
Only title is required. Others props are optional.
```php
#[
    Info(
        'title',
        '1.0.0',
        'description',
        'https://example.com/termsOfService',
        [
            'name' => 'API Support',
            'url' => 'https://example.com/support',
            'email' => 'support@output.json.com'
        ],
        [
            'name' => 'Apache 2.0',
            'url' => 'https://www.apache.org/licenses/LICENSE-2.0.html'
        ],
    ),
]
class BaseController 
{
    //
}
```

#### Define security schema

```php
#[
    SecurityScheme(
        'bearerAuth',
        'http',
        'bearerAuth',
        'header',
        'bearer',
        'JWT',
    ),
]
class BaseController 
{
    //
}
```