# Yii2 Maintenance - README

A module for providing maintenance mode redirection for Yii2 web applications

## Installation

### Install Using Composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require humanized/yii2-maintainable "dev-master"
```

or add

```
"humanized/yii2-maintainable": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Edit Configuration File

Add following lines to the configuration file:

```php
'modules' => [
    'maintenance' => [
        'class' => 'humanized\maintenance\Module',
    ],
],
```

Adding these lines allows access to the various interfaces provided by the module. 
Here, the chosen module-name is maintenance, as such the various routes will be available at maintenance/controller-id/action-id, though any module-name can be chosen.

Further, it is required that the behavior class provided by the module, is called before each request of the application to be placed under maintenance. For this, add following lines to the configuration file:

```php
return [
    'id' => 'application-name',
    ...
    'as beforeAction'=>[ 
      'class'=>'humanized\maintenance\component\RedirectBehavior',
    ]
    ...
],
```

For full instructions on how to use the fully-configured module, check the [USAGE](USAGE.md)-file.

## Important Note

The module conflicts with the Yii2 debug toolbar, which is enabled by default in a standard development environment. The module functions just fine, when the debug toolbar is disabled, i.e. as is the default case in a standard production environment
