AcYaml
======

[![Build Status](https://travis-ci.org/acelaya/ZF2-AcYaml.svg?branch=develop)](https://travis-ci.org/acelaya/ZF2-AcYaml)
[![Code Coverage](https://scrutinizer-ci.com/g/acelaya/ZF2-AcYaml/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/acelaya/ZF2-AcYaml/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acelaya/ZF2-AcYaml/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acelaya/ZF2-AcYaml/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/acelaya/zf2-acyaml/v/stable.svg)](https://packagist.org/packages/acelaya/zf2-acyaml)
[![Total Downloads](https://poser.pugx.org/acelaya/zf2-acyaml/downloads.svg)](https://packagist.org/packages/acelaya/zf2-acyaml)
[![License](https://poser.pugx.org/acelaya/zf2-acyaml/license.svg)](https://packagist.org/packages/acelaya/zf2-acyaml)


This module allows to work with Yaml responses the same way we do with JSON responses. Indeed, this module is pretty simple and is based on built-in JSON rendering classes (`View\JsonStrategy`, `View\JsonRenderer` and `View\JsonModel`) but using [Symfony\Yaml](https://github.com/symfony/Yaml) instead of `Zend\Json`.

### Installation

The only supported installation method is composer, however others could work too.

Get composer binary into your project.

    curl -s http://getcomposer.org/installer | php
    
And run this command in order to get this module installed.

    php composer.phar require acelaya/zf2-acyaml:~0.1
    
Finally add the module to your `application.config.php` file.

```php
return array(
    'modules' => array(
        'Application',
        'Acelaya\Yaml' // <- Add this line
    )
);
```

### Usage

The module will register a yaml view rendering strategy, so any action returning a `YamlModel` (which is very similar to the `JsonModel`) will make the response to be in yaml format, including the `Content-type` header with value `application/x-yaml`.

And that's it. No further configuration is needed. Nice and easy.
