# Yii2 Maintenance - USAGE

## Redirection Behavior

### Minimal Configuration

As defined in the [README](README.md)-file, minimal behavior configuration is setup in the root of the configuration file that effects the web application to be placed under maintenance. 

```php
return [
    'id' => 'application-name',
    ...
    'as beforeAction'=>[ 
      'class'=>'humanized\maintenance\component\RedirectionBehavior',
      //Add custom configuration options here
      ...
    ]
    ...
],
```

### Bypassing Redirection Behavior

By default, all requests are caught and a 503 HTTP Exception is thrown. The behavior provides multiple ways to bypass the default redirection flow. 


#### force (boolean)

Bypasses standard maintenance-mode status check, forcing it to always evaluate to true

#### bypassPermission (string)

Permission to be evaluated using Yii::$app->user->can() - Bypasses redirection when evaluating to true

#### bypassRedirection (boolean|callable)

Bypasses redirection when evaluating to true

When using a callback, use a function without parameters which returns a boolean value


#### whitelistLoginUrl

Bypass redirection for route setup by loginUrl through the Yii::$app->user component

#### whitelistErrorAction

Bypass redirection for route setup by errorAction through the Yii::$app->errorHandler component

#### whitelist

Array containing individual routes (e.g. /path/to/route) which bypass the redirection


## Command Line Interface

Maintenance mode can be toggled through command-line interface.

```
$ php  yii <module-name> enable|disable|status
``` 


When applying the behavior to multiple targets, it may be desirable to specify an alternative path or alias (mutually exclusive).
 
 
```
$ php  yii <module-name> enable|disable|status -a=<path-alias> (optional) -p=<path> (optional)
``` 

By default, the alias "@maintenance" is used which can be configured in the config/bootstrap.php file.
