# _Shoe Store_

#### _PHP Silex & Database Practice, 7.14.2017_

#### By _**Brittany Kerr**_

## Description

_This PHP database exercise allows the user to pretend they work for Szappos. The user can enter brand names with a price point. They can also enter a store name and add existing brands to the store. This is practice in using database basics with PHP in a many to many relationship._

## Setup Requirements

* Ensure that the following programs are downloaded to your computer:
  * [MAMP](https://www.mamp.info/en/) for Windows or MacOS
  * [PHP](https://secure.php.net/)
  * [Composer](https://getcomposer.org/)
* Sign into github and copy repository: https://github.com/kerrbrittany9/shoes
* From your local console:
  * Enter Desktop by typing "cd Desktop"
  * Type "git clone [add above URL]".
  * Type "cd shoes" to enter directory.
  * Download dependencies by typing "composer install" in console.
* Open preferences>ports on MAMP and verify that Apache Port is 8888.
* Go to preferences>web server and click the file folder next to document root.
  * Click web folder and hit select.
  * Click ok at the bottom of preferences.
  * Click start server.
* In browser type "localhost:8888/phpmyadmin"
  * Click 'import' tab, choose file 'shoes.sql.zip' and select 'go' to import database.
* In your browser, type 'localhost:8888' to view the webpage.
* Type a shoe store or brand name in input field to get started.

## Use stories

1. The user can add, delete and update shoe stores in order to view the list of stores available.
2. The user can add and list shoe brands with a price point attached in order to see the full catelog of shoes.
3. The user can add existing shoe brands to a shoe store and view the brands on each individual store's page.


## Technologies Used

* _PHP_
* _HTML_
* _Bootstrap CSS_
* _Silex_
* _Twig_
* _Composer_
* _MAMP_

### License

Copyright &copy; 2017 Brittany Kerr

This software is licensed under the MIT license.
