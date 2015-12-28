Sometime, a third-party send notification to our PHP application and we want to "see" it in a log file, just to test or to have an idea what the notification is before processing it.

So this small PHP application does only one thing:

- Log every requests in the `logs` folder 

It will also return the `phpinfo()` page.

The logging library [monolog](https://github.com/Seldaek/monolog) is used via [composer](https://getcomposer.org/).

This application works out the box (ready to be deploy on a PHP 5.6 server). because the `vendor` folder is also committed for peoples who don't want to bother with [composer](https://getcomposer.org/).