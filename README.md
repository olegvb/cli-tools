# PHP CLI Tools
Various CLI tools to use in PHP scripts.

Please see project page here:
https://github.com/olegvb/cli-tools

## Installation
### Using composer
```
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

## Included Tools:
### Tick
Print progress ticks with various characters.

Usage:
```PHP
use \Olegvb\CliTools\Tick;

for ($i=0;$i<1000;$i++) {
    Tick:tick();
}
```
