# This project is obsolete

We can use **requestcatcher.com** to catch the callback/notification

----

Sometime, a third-party sends notifications to our PHP application and we want to "see" them in a log file (for testing).

This small PHP application does only one thing:

**Log every requests to the `logs` folder**

The output page is simply `var_dump(request)`

The logging library [monolog](https://github.com/Seldaek/monolog) is used via [composer](https://getcomposer.org/).

This application works out of the box (ready to be deploy on a PHP 5.6 server), because the `vendor` folder is also committed for peoples who don't want to bother with [composer](https://getcomposer.org/).



