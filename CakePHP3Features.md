# Features
Since I have decided to release it, I'm trying to use the maximum of CakePHP 3's features :

## Behaviors
* Tree
    * Used with the Forum's Categories
* Timestamp
    * Used to allow Cake to modify the fields `created` and `modified` automatically
* CounterCache
    * To build counter automatically
        * Blog Comments 
        * Blog Articles 
        * Blog Articles Likes
        * Forum Threads
        * Forum Posts
        * Forum Posts Likes
* Custom Behavior :
    * Upload Behavior (Migrated into a plugin : [Cake3-Upload](https://github.com/Xety/Cake3-Upload))
        * To upload safely an avatar for user
    * Sluggable Behavior (Migrated into a plugin : [Cake3-Sluggable](https://github.com/Xety/Cake3-Sluggable))
        * Used to build slug when creating an user and creating an article

### Components
* Pagination
    * To build custom pagination request for the list of articles, users etc
* Sessions
    * To store user's information
* Authentication
    * For login/logout an user
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
* Flash
    * To render some flash message
* Text
    * To truncate some text
* Time
    * To build a new date time when an user try to login
* Custom Helpers :
    * ACL Helper
        * To check the permissions in a view
    * Forum Helper
        * To build the sub-categories
    * I18n Helper
        * To build translate inputs in form

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
    * Prefix : Admin, Forum, Chat
* Cache
    * To cache all Google Analytics requests in the Administration Panel
    * ACL authorizations
    * Chat Notice

### General
* Validation & Validator
    * Custom Validator
        * UploadValidator
        * PurifierValidator
        * Validator for the Contact Page (With an ArrayContext)
* View Cell
    * Blog Sidebar
    * Forum Sidebar
    * Forum Suggestion
    * Notifications
* Events System
    * Badge system
        * Badge on comment
        * Badge for register date
    * Followers
        * When a Thread is created
        * When a user reply to a Thread
    * Notifications
        * When a user reply to a Thread
        * When a user lock a Thread
        * When a user like a Post
* Authenticate
    * Cookies (Migrated into a plugin : [Cake3-CookieAuth](https://github.com/Xety/Cake3-CookieAuth))
        * For auto-login

* Plugins used
    * [Xety/Cake3-Upload](https://github.com/Xety/Cake3-Upload)
    * [Xety/Cake3-Sluggable](https://github.com/Xety/Cake3-Sluggable)
    * [Xety/Cake3-CookieAuth](https://github.com/Xety/Cake3-CookieAuth)
    * [Cake17/CakePHP-Recaptcha](https://github.com/Cake17/CakePHP-Recaptcha)
    * [Widop/Google-Analytics](https://github.com/Widop/Google-Analytics)
    * [Mexitek/PHPColors](https://github.com/Mexitek/PHPColors)
    * [Ezyang/HTMLPurifier](https://github.com/Ezyang/HTMLPurifier)
    * [CakePHP/ACL](https://github.com/CakePHP/ACL)
    * [Gourmet/Whoops](https://github.com/Gourmet/Whoops) (Dev only)