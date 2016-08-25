# PHP CLI Tools
Various CLI tools to use in PHP scripts.

Please see project page here:
https://github.com/olegvb/cli-tools

## Installation
### Using composer
```bash
$ composer require olegvb/cli-tools
```

Or include in your `composer.json` file:
```json
{
    "require": {
        "olegvb/cli-tools": "~0.1"
    }
}
```

## CLI Tools Tools:
### Tick
Print progress ticks with various characters.

Usage:
```php
use \Olegvb\CliTools\Tick;

for ($i=0;$i<1000;$i++) {
    Tick:tick();
}
```
