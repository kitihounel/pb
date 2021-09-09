# pb

This is the backend of the **Prescription Book** application.

Prescription Book is an web application that aims to help Beninese drug stores to track the sales
of prescription drugs. It can be used to generate quarterly reports that drug stores are required
to send to the Ministry of Health. 

- [Database Driver](#database-driver)
- [Add Common Artisan Commands to Lumen](#add-common-artisan-commands-to-lumen)
- [Set Application Key](#set-application-key)
- [Laravel IDE Helper](#laravel-ide-helper)
- [Add Helper functions](#add-helper-functions)
- [Eloquence](#eloquence)
- [Route Model Binding](#route-model-binding)
- [CORS and Options Requests](#cors-and-options-requests)
- [Form Requests](#form-requests)
- [Convert Request Parameters to Snake Case](#convert-request-parameters-to-snake-case)
- [Convert API Requests and Responses to Camel Case](#convert-api-requests-and-responses-to-camel-case)
- [Laravel Authentication: Under The Hood](#laravel-authentication-under-the-hood)
- [Add Wildcard Route to Lumen](#add-wildcard-route-to-lumen)
- [About POST and PUT](#about-post-and-put)

## Database Driver

We are using a SQLite database. So make sure that the PDO SQLite driver is installed.

```bash
sudo apt install php-sqlite3
```

## Add Common Artisan Commands to Lumen

We use Lumen Generator, https://github.com/flipboxstudio/lumen-generator.

### Installation

```bash
composer require flipbox/lumen-generator
```

### Configuration

Inside your bootstrap/app.php file, add:

```php
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
```

## Set Application Key

```bash
php artisan key:generate
```

## Laravel IDE Helper

Laravel IDE Helper can also work with Lumen after some tweaks.

### Installation

```bash
composer require --dev barryvdh/laravel-ide-helper
```

Then edit your `composer.json` to install version `1.1` of the `league/flysystem`
package on which `laravel-ide-helper` depends. Without that, it won't work. The following
is a stub from the `composer.json`. Don't forget to add `league/flysystem` as a development
package.

```json
"require-dev": {
  "flipbox/lumen-generator": "^8.2",
  "league/flysystem": "^1.1",
  "barryvdh/laravel-ide-helper": "^2.10",
  "fakerphp/faker": "^1.9.1",
  "mockery/mockery": "^1.3.1",
  "phpunit/phpunit": "^9.3"
}
```

Then update your packages.

```bash
composer update
```

### Configuration

Facades should be activated. Make sure that the following line is uncommented in `bootstrap/app.php`. 

```php
$app->withFacades();
```

Service providers should also be available. So be sure that the following line is also uncommented
in `bootstrap/app.php`.

```php
$app->register(App\Providers\AppServiceProvider::class);
```

Then in `app/Providers/AppServiceProvider`, register `laravel-ide-helper` when in dev mode.

```php
if ($this->app->environment() !== 'production') {
    $this->app->register(
        \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
    );
}
```

Then add the following to the `.gitignore` file.

```
_ide_helper.php
_ide_helper_models.php
```

Commit your changes before running the following to avoid that the two files being tracked.

```bash
php artisan ide-helper:generate
php artisan ide-helper:models # You need a working db connection for this
```

## Add Helper Functions

Create a file `app/helpers.php` and modify your `composer.json` file to add the `files` entry
to `autoload` section.

```json
{
    "autoload": {
        "files": [
            "path/to/helpers.php"
        ]
    }
}
```

Then run:

```bash
composer dump-autoload
```

## Eloquence

Install it with

```
composer require kirkbushell/eloquence
```

Next, add the eloquence service provider to your `bootstrap/app.php` file:

```php
$app->register(\Eloquence\EloquenceServiceProvider::class);
```

Finally, put the following line in your models and that's it.

```php
use \Eloquence\Behaviours\CamelCasing;
```

## Route Model Binding

Lumen doesn't support `Route Model Binding` out of the box due to the fact that Lumen doesn't
use the Illuminate router that Laravel uses. Instead, It uses FastRoute which is much faster.
With this package, We add support for the powerful Route Model Binding while still benefit the
speed of FastRoute in Lumen.

### Installation

```bash
composer require mmghv/lumen-route-binding "^1.0"
```

### Usage

Create a service provider that extends the package's one and place it in `app/Providers`:

```bash
php artisan make:provider RouteBindingServiceProvider
```

```php
namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteBindingServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider
     */
    public function boot()
    {
        // The binder instance
        $binder = $this->binder;

        // Here we define our bindings
    }
}
```

Then register it in `bootstrap/app.php`.

```php
$app->register(App\Providers\RouteBindingServiceProvider::class);
```

Now we can define our bindings in the `boot` method.

### Defining The Bindings

There are three types of binding. Only explicit binding is described here. For the other types,
read the package doc at https://github.com/mmghv/lumen-route-binding.

We can explicitly bind a route wildcard name to a specific model using the `bind` method:

```php
$binder->bind('user', 'App\User');
```

This way, anywhere in our routes if the wildcard `{user}` is found, It will be resolved to
the `User` model instance that corresponds to the wildcard value, so we can define our route like this:

```php
$app->get('profile/{user}', function(App\User $user) {
    doSomething();
});
```

Behind the scenes, the binder will resolve the model instance like this:

```php
$instance = new App\User;
return $instance->where($instance->getRouteKeyName(), $value)->firstOrFail();
```

### Customizing The Key Name

By default, it will use the model's ID column. Similar to Laravel, if you would like to use
another column when retrieving a given model class, you may override the `getRouteKeyName`
method on the Eloquent model :

```php
/**
 * Get the route key for the model.
 *
 * @return string
 */
public function getRouteKeyName()
{
    return 'slug';
}
```

## CORS and Options Requests

This is necessary to enable preflight requests from frontend. The process is described
[here](https://gist.github.com/danharper/06d2386f0b826b669552) and there is a good explaination
[here](https://stackoverflow.com/questions/43871637).

In a nutshell, you have to add a `CorsMiddleware` and a `CatchAllOptionsRequestsProvider`.

## Form Requests

Lumen doesn't have any FormRequest class like Laravel. The package `anik/form-request`
will let you do that.

### Installation

1. Install the package by running

```bash
composer require anik/form-request
```

2. Register `\Anik\Form\FormRequestServiceProvider::class` to your `bootstrap/app.php` as a provider.

```php
$app->register(\Anik\Form\FormRequestServiceProvider::class);
```

### Usage

1. Create a class that extends `Anik\Form\FormRequest` class.

2. You must override `rules` method of the `Anik\Form\FormRequest` class. Define your validation rules in it.
   Must return an array.

3. You can define validation messages by overriding `messages` method. Default is `[]`.

4. You can define custom pretty attribute names by overriding `attributes` method. Default is `[]`.

5. You can override `authorize` method to define the authorization logic if the client is authorized to
   submit the form. Must return a boolean value. Default is `true`. When returning `false`, it'll raise
   `\Illuminate\Auth\Access\AuthorizationException` exception.

For more doc, see the repo at https://github.com/ssi-anik/form-request.

## Convert Request Parameters to Snake Case
We use a middleware to convert request parameter keys to snake case. These eases a lot of things when
writing controllers and validation rules. The article describing the middleware is available @
https://dev.to/samolabams/transforming-laravel-request-data-using-middleware-2k7j.

It can be sometimes useful to detect if an array is sequential or associative. If this need rises, this SO thread
can be useful: https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential.
For our middleware, we don't need this check. The following code explains why.

```php
$ php -a
Interactive mode enabled

php > $a = ['0' => 'abc', '1' => 'fdb', '2' => 'rdf'];
php > echo json_encode($a);
["abc","fdb","rdf"]
php > 
```

Since the keys of the array are integers and given is order, the result array is sequential.

Note that if the keys are not given in order, the behaviour changes.

```php
php > $a = ['3' => 'bcd', '0' => 'abc', '1' => 'fdb', '2' => 'rdf'];
php > echo json_encode($a);
{"3":"bcd","0":"abc","1":"fdb","2":"rdf"}
php > 
```

## Convert API Requests and Responses to Camel Case
Although we did not use that in this project, it could be useful later. The aricle is available
@ https://gregkedzierski.com/essays/converting-laravel-api-requests-and-responses-to-camelcase/.

## Laravel Authentication: Under The Hood

A good article that explains how auth works in Laravel.
https://medium.com/@mariowhowrites/laravel-authentication-under-the-hood-78064b5b89e6.

## Add Wildcard Route to Lumen

Read the following thread: https://laracasts.com/discuss/channels/lumen/lumen-routing-any.

## About Post and Put

Great article about post and put verbs in HTTP. It also contains some advices about REST APIs.
https://blog.engineering.publicissapient.fr/2014/03/17/post-vs-put-la-confusion/.
