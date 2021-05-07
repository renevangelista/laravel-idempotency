# Laravel Idempotency Middleware

### Install

Require this package with composer using the following command:

```bash
composer require revangelista/laravel-idempotency 
```

### Usage

Register Idempotency middleware on your http kernel file:

```php
'api' => [
    'throttle:60,1',
    'bindings',
    \Idempotency\Idempotency::class,
]
```

To perform an idempotent request, provide an additional `Idempotency-Key: <key>` header to the request.

### How it works

If the header `Idempotency-Key` is present on the request and the request method is POST, 
the middleware stores the response on the cache. Next time you make a request with same idempotency key, the middleware 
will return the cached response.

How you create unique keys is up to you, it is strongly suggest to use V4 UUIDs or another appropriately random string. 
It'll always send back the same response for requests made with the same key, and keys can't be reused with different 
request parameters. Keys expire after 24 hours.  

To personalise the idempotency header name and the key expiration, 
publish config file:
```
php artisan vendor:publish --provider "Idempotency\IdempotencyServiceProvider"
```

And specify in the `.env` file like this:
```dotenv
IDEMPOTENCY_HEADER="My-Custom-Idempotency-Key",
IDEMPOTENCY_EXPIRATION=1440 #in minutes
```

Learn more about [Idempotency](https://developer.mozilla.org/en-US/docs/Glossary/Idempotent).

### License

The Laravel Idempotency is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
