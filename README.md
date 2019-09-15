# slim-console

The minimalistic slim framework console implementation.

## About

> So, what exactly is this package?

Well, it is a simple library for [Slim Framework 3](http://www.slimframework.com/docs/v3/) that allows you to call
controller actions from the console.

It utilizes the strategy design pattern to provide a flexible way of parsing a given argv array.

You can find more information on the php argv variable [here](https://www.php.net/manual/en/reserved.variables.argv.php).

Further it provides a small middleware class, designed to stop web-access to these actions.

## Installation

Run `composer require gameplayjdk/slim-console`.

Yes, it's that simple.

## Usage

Initial setup:

```php
<?php
// ...

$configuration = [];

$console = new \Slim\Console\Console();

if ($console->isSupported()) {
    $configuration['environment'] = $console->getEnvironment($argv);
}

$configuration['settings'] = [
    // ...
];

$app = new \Slim\App($configuration);

// ...
```

Middleware usage:

```php
<?php

// ...

$app->get('/cli/some-command', \App\Controller\CliController::class . ':someCommandAction')
    ->add($console->getMiddleware());

// ...
```

Call that action from the console:

```bash
php app.php cli some-command 
```

## License

The [MIT license](https://choosealicense.com/licenses/mit/).

## Open TODOs

- Write up some unittests
- More `ArgvParserInterface` implementations
