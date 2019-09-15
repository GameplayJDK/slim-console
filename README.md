# slim-console

The minimalistic slim framework console implementation.

## Installation

## Usage

```php
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

## License

The [MIT license](https://choosealicense.com/licenses/mit/).
