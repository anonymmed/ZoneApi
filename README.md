Zone Api
========================

Requirements
------------

  * PHP 7.1.3 or higher;
  * composer : https://getcomposer.org/download/
  * Symfony : https://symfony.com/download

Installation
------------
$ cd zoneApi
$ composer install
Usage
-----

You Need to update the .Env file with your current Database info : 
DATABASE_URL=mysql://user:password@127.0.0.1:3306/database


```bash
$ cd zoneApi/
$ symfony server:start
```

If you don't have the Symfony client installed, run `php bin/console server:run`.
Alternatively, you can [configure a web server][3] like Nginx or Apache to run
the application.
