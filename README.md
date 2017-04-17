# Xeta : CakePHP 3 Resource
<p align="center">
  <img src="https://cloud.githubusercontent.com/assets/8210023/21071044/ca810e6a-be94-11e6-8524-ec950ad60ff0.png" alt="Xeta Logo" height="80"/>
</p>

|Travis|Coverage|Scrutinizer|Stable Version|Downloads|License|
|:------:|:-------:|:-------:|:------:|:------:|:------:|
|[![Build Status](https://img.shields.io/travis/XetaIO/Xeta.svg?style=flat-square)](https://travis-ci.org/XetaIO/Xeta)|[![Coverage Status](https://img.shields.io/coveralls/XetaIO/Xeta/master.svg?style=flat-square)](https://coveralls.io/r/XetaIO/Xeta)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/XetaIO/Xeta.svg?style=flat-square)](https://scrutinizer-ci.com/g/XetaIO/Xeta)|[![Latest Stable Version](https://img.shields.io/packagist/v/Xety/Xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)|[![Total Downloads](https://img.shields.io/packagist/dt/xety/xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)

Xeta is a resource to help people starting with Cake3.

Actually, I have developed this blog to try CakePHP 3 and for my needs (personal blog), and I have decided to release it to help people with CakePHP 3, so there is probably some custom configurations/functions that only fit my needs.

## Demo
https://xeta.io

### Screenshots of the Administration Panel
##### Dashboard
![Dashboard](https://cloud.githubusercontent.com/assets/8210023/19932908/f9204772-a111-11e6-84f5-750f15adc576.png)

##### Blog Articles Management
![Blog Articles Management](https://cloud.githubusercontent.com/assets/8210023/19932809/9f23fc6e-a111-11e6-89c3-bb53705fbd93.png)

![Blog Articles Management](https://cloud.githubusercontent.com/assets/8210023/19932872/dd69977c-a111-11e6-92a4-e16bcfb89e8e.png)

##### Users Management
![Users Management](https://cloud.githubusercontent.com/assets/8210023/19932834/b83c050c-a111-11e6-88c3-b122b30f9c08.png)

# Install
If you need to install to try a function or any other things, just follow the steps bellow.

### Requirements
* :package: ![PHP](https://img.shields.io/badge/PHP->=5.6-44CB12.svg?style=flat-square)
* :package: [Composer](https://getcomposer.org)
* :cake: All requirements for CakePHP 3 : [list here](http://book.cakephp.org/3.0/en/installation.html#requirements)
* :package: PHP cURL extension
* :package: Supported DBMS : MySQL
* :package: [Google Recaptcha](https://www.google.com/recaptcha/intro/index.html) (For the register form)

Steps to install :
* Setup a new database on your server
* Run :
```
composer create-project --prefer-dist xety/xeta <application_name>
composer run-script installation
```
You need to download the browscap.ini file.
```
vendor/bin/browscap-php browscap:fetch
vendor/bin/browscap-php browscap:convert
```
* Congratulations ! The application is ready to use. :+1:

#### Pre-installed Accounts
* Admin account
    * User : Admin | Pass : `administrator`
* Member account
    * User : Test | Pass : `testaccount`

# Documentation
https://github.com/XetaIO/Xeta/wiki

# Features
This project implements many features and will implements more in the future. Here's a list of the features developed in Xeta :

* ###### Blog
    * Categories
    * Comments
    * Likes Articles
    * Article's Internationalization (You change your language, the article is also translated in the language that you have choosen)
    * Archives
    * Quote
    * Attachments

* ###### Admin Panel
    * Google Analytics integrated
    * Members Management
    * Blog Management
        * Attachments
        * Categories
        * Articles
    * Groups Management
    * Settings Management

* ###### Private Conversations
    * Multi-Participants
    * Kick/Invite Participants
    * `Star` Conversations

* ###### Two Factor Authentication (TOTP)

* ###### Logs
    * Preview
![Logs Preview](https://cloud.githubusercontent.com/assets/8210023/20028971/0dff8060-a340-11e6-8487-62b3e2ff8350.png)

    * Logs Events list :

|Command|Description|
|------|-------|
|`user.connection.manual.success`|Triggered when the user login on the login page.|
|`user.connection.manual.failed`|Triggered when the user failed to login on the login page.|
|`user.connection.auto`|Triggered when the user is automated login with Cookies.|
|`user.account.modify`|Triggered when the user has modified his account.|
|`user.email`|Triggered when the user has changed his Email.|
|`user.password.change`|Triggered when the user has changed his password.|
|`user.password.reset`|Triggered when the user has asked a password reset.|
|`user.password.reset.successful`|Triggered when an user has successfully reset his password with the Email.|
|`2FA.enabled`|Triggered when an user enbale the 2FA mode.|
|`2FA.disabled`|Triggered when an user disable the 2FA mode.|
|`2FA.recovery_code.regenerate`|Triggered when an user regenerate a new recovery code.|
|`2FA.recovery_code.used`|Triggered when an user use his recovery code.|


* ###### WYSIWYG Editor (CKEditor)
    * Articles, Comments

All the CakePHP3's features that i use in the project are described [here](https://github.com/XetaIO/Xeta/blob/master/CakePHP3Features.md).

# Information
If you want to contribute to the project by adding new features or just fix a bug, feel free to do a PR.

# Contribute
[Follow this guide to contribute](https://github.com/XetaIO/Xeta/blob/master/.github/CONTRIBUTING.md)

# Special Thanks
* [Antograssiot](https://github.com/antograssiot) (CakePHP Team Member) For all his help !
* And all the [contributors](https://github.com/XetaIO/Xeta/graphs/contributors) !
