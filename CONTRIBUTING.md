# How to Contribute
* You have found a bug ? You can open an [issue](https://github.com/Xety/Xeta/issues/new). (For a security issue, please send me a mail : [here](mailto:zoro-fmt@gmail.com)) :
	* Clearly describe the issue including steps to reproduce when it is a bug.
	* Make sure you fill in the earliest version that you know has the issue.
	* Screenshots and code exemple are welcome in the issues.

* You have found a bug related to CakePHP 3 ?
	* Be sure that it's a CakePHP 3 related issue and not a Xeta's issue.
	* Ensure that the issue doesn't exist in the [issues list](https://github.com/cakephp/cakephp/issues).
	* Open an issue in the [CakePHP 3 repository](https://github.com/cakephp/cakephp/issues/new).

* You want to implement a new feature or fix a bug ? Please follow this guide :
	* Your code **must follow** the [Coding Standard of CakePHP](http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html). Check the [cakephp-codesniffer](https://github.com/cakephp/cakephp-codesniffer) repository to setup the CakePHP standard.
	* You must **add Test Cases** for your new feature. Test Cases ensure that the application will continue to working in the future.
	* Your PR should be on the `master` branch. The master branch is actually the dev branch.

* I want contribute to the design but the CSS is minified !
	* Unfortunately, i didn't release the LESS files, because i don't want that people use the design for their websites.
	* If you want to make some modifications on the CSS files, ask me in a issue. I will create a new branch, so i will be able to contribute to your PR.
	* Your PR **should be** on this new branch and not the master branch.
	* You can `beautify` the CSS file with [this tool](http://codebeautify.org/css-beautify-minify) and make your PR with the CSS **not** minified.
	* When your PR will be ready to merge, then i will commit the CSS minified in your PR and merge your PR.