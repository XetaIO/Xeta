# Contribute
Your code **must follow** the [Coding Standard of CakePHP](http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html).

## Getting Started
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
