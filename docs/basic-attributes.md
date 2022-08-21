---
lang: en-US
title: Define basic attributes
prev: ./installation
next: ./routes
---

# Basic attributes

The `info` attribute must be declared in your project. We recommend to write it in the base class of the controller. For example:

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApiGenerator\Attributes\Info;

#[Info('Application')]
class Controller
{
    //
}
```

Now you can generate empty openapi documentation. Run the command `openapi:generate` 

```bash
php artisan openapi:generate
```
