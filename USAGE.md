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
    ]
    ...
],
```

### Bypassing Redirection Behavior

### Whitelisting Routes

## Command Line Interface
