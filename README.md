# Cake3 Blog Resource

[![Build Status](https://img.shields.io/travis/Xety/Xeta.svg?style=flat-square)](https://travis-ci.org/Xety/Xeta)
[![Coverage Status](https://img.shields.io/coveralls/Xety/Xeta/master.svg?style=flat-square)](https://coveralls.io/r/xety/xeta)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Xety/Xeta.svg?style=flat-square)](https://scrutinizer-ci.com/g/Xety/Xeta)
[![Latest Stable Version](https://img.shields.io/packagist/v/Xety/Xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)
[![Total Downloads](https://img.shields.io/packagist/dt/xety/xeta.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/xety/xeta)

Cake3 Blog Resource, is a resource to help people starting with Cake3.

Actually, I have developed this blog to try Cake3 and for my needs (personal blog), and I have decided to release it to help people with Cake3, so there is probably some custom configurations/functions that only fit my needs.

**It is not recommended to do a website with Cake3 until the first stable Cake3 version will be released.**

## Demo
http://xeta.io

### Screenshots of the Administration Panel
##### Dashboard
![Dashboard](https://cloud.githubusercontent.com/assets/8210023/4525906/5e355904-4d59-11e4-9ba5-f660c403e39c.png)
![Dashboard](https://cloud.githubusercontent.com/assets/8210023/4525908/6663383a-4d59-11e4-9522-be42a69124f5.png)

##### Articles Management
![Articles Management](https://cloud.githubusercontent.com/assets/8210023/4525857/e61fa3e8-4d58-11e4-8fa2-b71d13abab16.png)
![Articles Management](https://cloud.githubusercontent.com/assets/8210023/4525865/f5c1f56c-4d58-11e4-82c1-98ec08020455.png)

##### Categories Management
![Categories Management](https://cloud.githubusercontent.com/assets/8210023/4525878/18b56aae-4d59-11e4-87fb-30ee78e885ae.png)

# Install
If you need to install to try a function or any other things, just follow the steps bellow.

### Requirements
* :package: [Composer](https://getcomposer.org)
* :package: All requirements for CakePHP : [list here](http://book.cakephp.org/3.0/en/installation.html#requirements)
* :package: PHP cURL extension (Needed only if you want to use the Google Analytics system in Dashboard)
* :package: Supported DBMS : MySQL & SQLite

Steps to install :
* Setup a new database on your server
* Run :
```
composer create-project --dev xety/xeta <application_name> 1.0.*
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
Since I have decided to release it, I'm trying to use the maximum of Cake3's features :

## Behaviors
* Timestamp
    * Used to allow Cake to modify the fields `created` and `modified` automatically
* CounterCache
    * To build counter automatically
        * Comments count
        * Likes count
* Custom Behavior :
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
    * To authorize an user to access in the Administration Panel
* Flash
    * With custom message : Error, Success, Info, Primary
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
* Cache
    * To cache all Google Analytics requests in the Administration Panel

### General
* Validation & Validator
    * Custom Validator
        * UploadValidator
        * PurifierValidator
        * Validator for the Contact Page (With an ArrayContext)
* View Cell
    * Blog sidebar

# Information
If you want to contribute to the project by adding new features or just fix a bug, feel free to do a PR.

# Contribute
[Follow this guide to contribute](https://github.com/Xety/Xeta/blob/master/CONTRIBUTING.md)

# Special Thanks
* [Antograssiot](https://github.com/antograssiot) (Cake Team Member) For all his help !
