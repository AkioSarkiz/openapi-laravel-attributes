---
lang: en-US
title: Installation
prev: ./
next: ./basic-attributes
---

# Installation

#### Requirements
> php 8.0+  
> json-ext  
> Laravel 8  

1. First, install Pest via the Composer package manager:
```bash
composer require akiosarkiz/openapi-laravel-attributes
```

2. If you do not run Laravel 5.5 (or higher), then add the service provider in `config/app.php`:
```php
\AkioSarkiz\Openapi\OpenapiAttributesServiceProvider::class
```

3. Add command `\AkioSarkiz\Openapi\Commands\GenerateOpenap` to `\App\Console\Kernel`

```php
<?php

declare(strict_types=1);

namespace App\Console;

use AkioSarkiz\Openapi\Commands\GenerateOpenapi;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var string[]
     */
    protected $commands = [
        GenerateOpenapi::class,
    ];
}
```
