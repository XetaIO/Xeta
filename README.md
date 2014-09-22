# Cake3 Blog Resource

[![Build Status](https://travis-ci.org/Xety/Xeta.svg)](https://travis-ci.org/Xety/Xeta)

Cake3 Blog Resource, is a resource to help people starting with Cake3.

Actually, I have developed this blog to try Cake3 and for my needs (personal blog), and I have decided to release it to help people with Cake3, so there is probably some custom configurations/functions that only fit my needs.

**It is not recommended to do a website with Cake3 until the first stable Cake3 version will be released.**

## Demo
http://xeta.io
    * User : test | Pass : 12345678

# Install
If you need to install to try a function or any other things, just follow the steps bellow.

### Requirements
* :package: [Composer](https://getcomposer.org)
* :package: All requirements for CakePHP : [list here](http://book.cakephp.org/3.0/en/installation.html)
* :coffee: Some cups of coffee

Steps to install :
* Setup a new database
* Import the file `config/Schema/xeta.sql`
* Rename the file `config/app.default.php` to `app.php`
* Configure your database in this file [config/app.default.php](https://github.com/Xety/Xeta/blob/master/config/app.default.php#L206-L216)  (Do not change the SALT, else the account Admin and Test will not work)
* Run the command `composer update` in the root directory to install the lastest version of CakePHP3 and all dependencies.

#### Pre-installed Accounts
* Admin account
    * User : Admin | Pass : administrator
* Member account
    * User : Test | Pass : testaccount

# Features
Since I have decided to release it, I'm trying to use the maximum of Cake3's features :

## Behaviors
* Timestamp
    * Used to allow Cake to modify the fields `created` and `modified` automatically
* CounterCache
    * To build counter automatically
        * Comments count
        * Likes count
* Custum Behavior :
    * UploadBehavior
        * To upload safely an avatar for user
    * Sluggable Behavior
        * Used to build slug when creating an user and creating an article

### Components
* Pagination
    * To build custom pagination request for the list of articles, users etc
* Sessions
    * To store user's information
* Authentication
    * For login/logout an user
* Flash
    * With custum message : Error, Success, Info, Primary
* Cross Site Request Forgery (CSRF)
    * To provide the max security
* Request Handling
    * To render json views (Used with AJAX request/response)

### Helpers
* Url
    * To build URLs for AJAX request. (Like system)
* Form
* Html
* Number
    * To build beautiful number for comments/likes count.
* Paginator
    * To build beautiful pagination
* Session
    * To access to the user Session information
* Flash
    * To render some flash message
* Text
    * To truncate some text
* Time
 * To build a new date time when an user try to login

### Utilities
* Email
    * In the Contact page
* Folder & File
    * With the UploadBehavior
* Inflector
    * With the SluggableBehavior
* Internationalization & Localization
* Router
    * To build custom routes names
    * Prefix (admin)

### General
* Validation & Validator
    * Custum Validator
        * UploadValidator
        * PurifierValidator
* View Cell
    * Blog sidebar

# Todo
* Panel Administration
    * Manage Articles
    * Manage Categories
    * Manage Users
* Captcha on the Register form

# Information
As i said before, if you want to install it, you **must** download the latest commit of [Cake3 on Github](https://github.com/cakephp/cakephp/tree/3.0) and **not only** the version Cake3 Beta1, because we have fixed some bugs with the Cake Team.

If you want to contribute to the project by adding new features or just fix a bug, feel free to do a PR.

Your code **must follow** the [Coding Standard of CakePHP](http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html).
You can set up a Code Sniffer :
* First you need to install PEAR : [Installation Guide](http://pear.php.net/manual/fr/installation.getting.php)
* Now you need to install PHP_CodeSniffer **with PEAR** : `pear install PHP_CodeSniffer`
* And finally, install the CakePHP Standard configuration : [Installation Guide](https://github.com/cakephp/cakephp-codesniffer#installation)

Ok, now you need to set up your editor with the CakePHP configuration :
* Atom
    * Install the packages `Linter` and `Linter-phpcs`
    * In your Settings, in the Linter-phpcs settings :
        * Standard : `CakePHP`
        * Phpcs Executable Path :
            * The full path of the phpcs.bat (For example, for me : `C:\Program Files (x86)\Wamp\bin\php\php5.5.12\phpcs.bat`)
* PhpStorm 7/8
    * `File` -> `Settings` -> `PHP` -> `Code Sniffer`
        * Choose the phpcs.bat (For example, for me : `C:\Program Files (x86)\Wamp\bin\php\php5.5.12\phpcs.bat`)
    * Now : `File` -> `Settings` -> `Inspections`
        * In the tree : `PHP` -> `PHP Code Sniffer validation`
        * In the `Coding Standard` list, choose `CakePHP` (If you don't have CakePHP, try to refresh the list with the button at the right)
