---
lang: en-US
title: Definition routes
prev: ./basic-attributes
next: ./schemas
---

# Define routes

In order for your root to be included in the documentation you must add the `Route` attribute to your method handler.
It will automatically detect the path and method and try to determine the validation rules. 
Sometimes the validation definition doesn't work because the quest is complex. 
You can disable the request body parsing attempt with ```phpRoute(body: 'disable')```.
Or create a factory to generate the body of your query. You can read about it down.

```php
<?php

declare(strict_types=1);

use OpenApiGenerator\Attributes\Property\Str;
use AkioSarkiz\Openapi\Attributes\Route;

class SimpleController
{
    #[Route]
    public function get(): void
    {
        //
    }
}
```

#### Create Factory

```php
<?php

declare(strict_types=1);

use AkioSarkiz\Openapi\Contacts\PayloadFactory;

class UpdateUserFactory implements PayloadFactory
{
    /**
    * @inheritDoc
    */
    public function generate(): array
    {
        //  
    }
}

```

#### Use Factory

```php
<?php

declare(strict_types=1);

use Illuminate\Http\Request;

#[Factory(UpdateUserFactory::class)]
class UpdateUserRequest extends Request 
{ 
    //
}

```
