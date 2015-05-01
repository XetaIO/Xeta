# Features
Since I have decided to release it, I'm trying to use the maximum of CakePHP 3's features :

## Behaviors
* Timestamp
    * Used to allow Cake to modify the fields `created` and `modified` automatically
* CounterCache
    * To build counter automatically
        * Comments count
        * Likes count
* Custom Behavior :
    * UploadBehavior (Migrated into a plugin : [Cake3-Upload](https://github.com/Xety/Cake3-Upload))
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
* Events System
    * Badge system
        * Badge on comment
        * Badge for register date
* Authenticate
    * Cookies (Migrated into a plugin : [Cake3-CookieAuth](https://github.com/Xety/Cake3-CookieAuth))
        * For auto-login
