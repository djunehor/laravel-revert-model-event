# Laravel Model Event Log & Revert
[![CircleCI](https://circleci.com/gh/djunehor/laravel-revert-model-event.svg?style=svg)](https://circleci.com/gh/djunehor/laravel-revert-model-event)
[![Latest Stable Version](https://poser.pugx.org/djunehor/laravel-revert-query/v/stable)](https://packagist.org/packages/djunehor/laravel-revert-query)
[![Total Downloads](https://poser.pugx.org/djunehor/laravel-revert-query/downloads)](https://packagist.org/packages/djunehor/laravel-revert-query)
[![License](https://poser.pugx.org/djunehor/laravel-revert-query/license)](https://packagist.org/packages/djunehor/laravel-revert-query)
[![StyleCI](https://github.styleci.io/repos/213029621/shield?branch=master)](https://github.styleci.io/repos/213029621)
[![Build Status](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/badges/build.png?b=master)](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/djunehor/laravel-revert-model-event/?branch=master)

Laravel Model Event Logger and Revert logs every action on a model (create, delete, update), provides an interface to see the list of all activities as well as revert specific model event.

- [Laravel Model Event](#laravel-model-event)
    - [Installation](#installation)
        - [Laravel 5.5 and above](#laravel-55-and-above)
        - [Laravel 5.4 and older](#laravel-54-and-older)
        - [Lumen](#lumen)
    - [Usage](#usage)
        - [All parts of speech](#get-all-parts-of-speech)
        - [Get part of speech](#get-word-part-of-speech)
    - [Contributing](#contributing)

## Installation

### Step 1
You can install the package via composer:

```shell
composer require djunehor/laravel-revert-query
```

#### Laravel 5.5 and above

The package will automatically register itself, so you can start using it immediately.

#### Laravel 5.4 and older

In Laravel version 5.4 and older, you have to add the service provider in `config/app.php` file manually:

```php
'providers' => [
    // ...
    Djunehor\EventRevert\EventRevertServiceProvider::class,
];
```
#### Lumen

After installing the package, you will have to register it in `bootstrap/app.php` file manually:
```php
// Register Service Providers
    // ...
    $app->register(Djunehor\EventRevert\EventRevertServiceProvider::class);
];
```

### Step 2 - Publishing files
- Run:
`php artisan vendor:publish --tag=ModelEventLogger`
This will move the migration file, seeder file and config file to your app.
- Open `config/model-event-logger` to set the model name and ID of users allowed to access to model event log routes
- the ID can be a number or list of comma-separated numbers e.g `1,2,3,4,5`

### Step 3 - SetUp database
- Run`php artisan migrate` to create the table.


## Usage
```php
use Djunehor\EventRevert\ModelEventLogger;`
```
- Add `use ModelEventLogger` to your laravel model

### Access Saved model event logs
|Endpoint|Description|
|:------------- | :----------: |
|`/model-events`|return all saved model events|
|`/model-events/{log}`|return all model events of a specific model|
|`/model-event-revert/{id}`|revert specific model event|


### Reverting via Console
If you know the specific ID of the event you which you revert, you can run:
`php artisan model:revert --id=EVENT_ID`

## Contributing
- Fork this project
- Clone to your repo
- Make your changes and run tests `composer test`
- Push and create Pull Request
