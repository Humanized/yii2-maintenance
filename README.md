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

## Configuration

### Step 1

The module works by creating/dropping a file somewhere on the filesystem. To specify it's path, add an alias "@maintenance" to the the config/bootstrap file:

```php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@maintenance', dirname(dirname(__DIR__)) . '/frontent/runtime/maintenance');
```

Add specific aliases to different application config/bootstap files to allow maintenance-mode on different applications within the same yii project.


### Step 2

The module comes with a redirecton behavior, which is triggered before a controller-action event. When attached to a controller, a 503 - Service Unavailable - HTTP exception is thrown when maintenance mode is enabled. 

To call the behavior before each request of the application to be placed under maintenance, add following lines to the configuration file:

```php
return [
    'id' => 'application-name',
    ...
    'as beforeAction'=>[ 
      'class'=>'humanized\maintenance\components\RedirectionBehavior',
    ]
    ...
],
```

### Step 3 (Optional)

Add following lines to the console configuration file to enable the CLI:

```php
'modules' => [
    'maintenance' => [
        'class' => 'humanized\maintenance\Module',
    ],
],
```

Adding these lines allows access to the CLI provided by the module. 
Here, the chosen module-name is maintenance, as such the various routes will be available at maintenance/controller-id/action-id, though any module-name can be chosen.

For full instructions on how to use the fully-configured module, check the [USAGE](USAGE.md)-file.

## Important Note

The module conflicts with the Yii2 debug toolbar, which is enabled by default in a standard development environment. The module functions just fine, when the debug toolbar is disabled, i.e. as is the default case in a standard production environment
