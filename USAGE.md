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
      //Customise options here
      ...
    ]
    ...
],
```

### Bypassing Redirection Behavior



#### force (boolean)

Bypasses standard maintenance-mode status check, forcing it to always evaluate to true evaluation to true

#### bypassPermission (string)

Permission to be evaluated using Yii::$app->user->can() - Bypasses redirection when evaluating to true


#### bypassRedirection (boolean|callable)

Bypasses redirection when evaluating to true

#### whitelist

##### whitelistLoginUrl

Bypass redirection for route setup by loginUrl through the Yii::$app->user component

##### whitelistErrorAction

Bypass redirection for route setup by errorAction through the Yii::$app->errorHandler component

### Whitelisting Routes

## Command Line Interface
