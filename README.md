# Laravel Revert DB Migrate

Laravel Revert DB Migrate gives you the option to run a specific migration or run migrations in a specified folder. it also allows you revert specific migration(s)

- [Laravel CherryPick DB Migrate](#laravel-custom-db-migrate)
    - [Installation](#installation)
        - [Laravel 5.5 and above](#laravel-55-and-above)
        - [Laravel 5.4 and older](#laravel-54-and-older)
        - [Lumen](#lumen)
    - [Usage](#usage)
        - [Migrate specific file](#migrate-specific-file)
        - [Migrate specific directory](#migrate-specific-directory)
        - [Reverting migrations](#reverting-migrations)
    - [Credits](#credits)

## Installation

You can install the package via composer:

```shell
composer require djunehor/laravel-revert-migration
```

### Laravel 5.5 and above

The package will automatically register itself, so you can start using it immediately.

### Laravel 5.4 and older

In Laravel version 5.4 and older, you have to add the service provider in `config/app.php` file manually:

```php
'providers' => [
    // ...
    Djunehor\CherryPick\CherryPickMigrateServiceProvider::class,
];
```
### Lumen

After installing the package, you will have to register it in `bootstrap/app.php` file manually:
```php
// Register Service Providers
    // ...
    $app->register(Djunehor\CherryPick\CherryPickMigrateServiceProvider::class);
];
```

## Usage

After installing the package, you will now see a new ```php artisan migrate:cherrypick``` command.

### Migrate specific file

You can migrate a specific file inside your `database/migrations` folder using:

```php artisan migrate:cherrypick -f 2014_10_12_000000_create_users_table``` or ```php artisan migrate:custom --file 2014_10_12_000000_create_users_table```

### Migrate specific directory

You can migrate a specific directory inside your `database/migrations` folder using:

```php artisan migrate:cherrypick -d migrations-subfolder``` or ```php artisan migrate:cherrypick --directory migrations-subfolder```

### Reverting migrations

You can revert migrations inside your project using:

```php artisan migrate:cherrypick -f 2014_10_12_000000_create_users_table -r true``` or ```php artisan migrate:cherrypick --file 2014_10_12_000000_create_users_table --revert```

## Credits

- [Md. Hasan Sayeed](https://github.com/nilpahar)

 For any questions, you can reach out to the author of this package, Zacchaeus Bolaji.

 Thank you for using it.
"# laravel-revert-model-event" 
