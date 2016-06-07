# Yii2 Maintenance - USAGE


## Module Configuration

## Behavior Configuration

### Minimal Configuration

As defined in the [README](README.md)-file, minimal behavior configuration is setup in the root of the configuration file that effects the web application. 

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

## Graphical User Interface

## Command Line Interface
