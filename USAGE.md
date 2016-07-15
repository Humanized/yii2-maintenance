# Yii2 Maintenance - USAGE


## Command Line Interface

By default, the alias "@maintenance" is used which can be configured in the config/bootstrap.php file.

It is required that the console application has access to the alias, and that the path specified is writable by the web application.


### Single Target

Maintenance mode can be toggled through command-line interface.

```
$ php  yii <module-name> enable|disable|status
``` 

### Multiple Targets

When applying the behavior to multiple targets, e.g. on seperate front-end and back-end applications, it may be desirable to specify an alternative path or alias (mutually exclusive).
 
 
```
$ php  yii <module-name> enable|disable|status -a=<path-alias> (optional) -p=<path> (optional)
``` 

