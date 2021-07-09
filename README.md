# pb

Prescription Book backend

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
