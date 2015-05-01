# Xeta : CakePHP 3 Resource
<p align="center">
  <img src="https://xeta.io/img/xeta-logo.svg" alt="Xeta Logo" height="120"/>
</p>

|Travis|Appveyor|Coverage|Landscape|Scrutinizer|
|:------:|:-------:|:-------:|:------:|:------:|
|[![Build Status](https://img.shields.io/travis/Xety/Xeta.svg?style=flat-square)](https://travis-ci.org/Xety/Xeta)|[![Build Status](https://img.shields.io/appveyor/ci/Xety/Xeta.svg?style=flat-square)](https://travis-ci.org/Xety/Xeta)|[![Coverage Status](https://img.shields.io/coveralls/Xety/Xeta/master.svg?style=flat-square)](https://coveralls.io/r/Xety/Xeta)|[![Code Health](https://landscape.io/github/Xety/Xeta/master/landscape.svg?style=flat-square)](https://landscape.io/github/Xety/Xeta/master)|[![Scrutinizer](https://img.shields.io/scrutinizer/g/Xety/Xeta.svg?style=flat-square)](https://scrutinizer-ci.com/g/Xety/Xeta)|

|Stable Version|Downloads|VersionEye|License|CakePHP|
|:------:|:-------:|:-------:|:------:|:------:|
|[![Latest Stable Version](https://img.shields.io/packagist/v/Xety/Xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)|[![Total Downloads](https://img.shields.io/packagist/dt/xety/xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)|[![Version EYE](https://img.shields.io/versioneye/d/ruby/rails.svg?style=flat-square)](https://www.versioneye.com/user/projects/55430de8d8fe1a25cc000053)|[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)|[![CakePHP 3](https://img.shields.io/badge/CakePHP 3-%E2%99%A5-44CB12.svg?style=flat-square)](http://cakephp.org)

Xeta is a resource to help people starting with Cake3.

Actually, I have developed this blog to try CakePHP 3 and for my needs (personal blog), and I have decided to release it to help people with CakePHP 3, so there is probably some custom configurations/functions that only fit my needs.

## Demo
https://xeta.io

### Screenshots of the Administration Panel
##### Dashboard
![Dashboard](https://cloud.githubusercontent.com/assets/8210023/7332853/4fceaaaa-eb56-11e4-8563-9afd7e7701ef.png)

##### Blog Articles Management
![Blog Articles Management](https://cloud.githubusercontent.com/assets/8210023/4525857/e61fa3e8-4d58-11e4-8fa2-b71d13abab16.png)
![Blog Articles Management](https://cloud.githubusercontent.com/assets/8210023/4525865/f5c1f56c-4d58-11e4-82c1-98ec08020455.png)

##### Blog Categories Management
![Blog Categories Management](https://cloud.githubusercontent.com/assets/8210023/4525878/18b56aae-4d59-11e4-87fb-30ee78e885ae.png)

##### Forum Categories Management
![Forum Categories Management](https://cloud.githubusercontent.com/assets/8210023/7332863/db94563e-eb56-11e4-9210-5032ad3f1820.png)

# Install
If you need to install to try a function or any other things, just follow the steps bellow.

### Requirements
* :package: [Composer](https://getcomposer.org)
* :package: All requirements for CakePHP 3 : [list here](http://book.cakephp.org/3.0/en/installation.html#requirements)
* :package: PHP cURL extension (Needed only if you want to use the Google Analytics system in Dashboard)
* :package: Supported DBMS : MySQL & SQLite
* :package: [Google Recaptcha](https://www.google.com/recaptcha/intro/index.html) (For the register form)

Steps to install :
* Setup a new database on your server
* Run :
```
composer create-project --prefer-dist xety/xeta <application_name>
```
* Import the file `config/Schema/xeta.sql` in your database.
* Congratulations ! The application is ready to use. :+1:


##### Install Google Analytics system in Dashboard
If you want to install the Google Analytics (not required), please follow the tutorial in the wiki :
https://github.com/Xety/Xeta/wiki

#### Pre-installed Accounts
* Admin account
    * User : Admin | Pass : `administrator`
* Member account
    * User : Test | Pass : `testaccount`

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

* ###### Forum
    * Categories (Managed by the TreeBehavior. That means unlimited sub-categories)
    * Statistics (Total Post, Threads, Likes)
    * Users online on the site
    * Staff Online
    * Followers (Follow a Thread to get notified on reply)
    * Notifications (On Thread Replied, On Thread Created, On Locked Thread, On Badge etc)
    * Sticky Threads
    * Locked Threads
    * Likes on Posts
    * "There is X Users on this page"
    * Latest Threads
    * Polls (Will be added in the Future)
    * Read/Unread system (Will be added soon)

* ###### Chatbox (AJAX)
    * Users online in the chat
    * Ban/Unban/Prune command
    * Delete a message
    * Notice
    * Smileys

* ###### Premium
    * Support of Paypal
    * Discounts Code
    * Offers

* ###### Admin Panel
    * Google Analytics integrated
    * Members Management
    * Blog Management
        * Attachments
        * Categories
        * Articles
    * Groups Management
    * Premium Management
        * Statistics
        * Offers
        * Discounts
    * Forum Management
        * Categories

* ###### ACL
    * ACL Management (Still in Dev)

* WYSIWYG Editor (CKEditor) on all the site : Articles, Comments, Posts, Notice in the chat etc

All the CakePHP3's features that i use in the project are described [here](https://github.com/Xety/Xeta/blob/master/CakePHP3Features.md).

# Information
If you want to contribute to the project by adding new features or just fix a bug, feel free to do a PR.

# Contribute
[Follow this guide to contribute](https://github.com/Xety/Xeta/blob/master/CONTRIBUTING.md)

# Special Thanks
* [Antograssiot](https://github.com/antograssiot) (CakePHP Team Member) For all his help !
* And all the contributors !
