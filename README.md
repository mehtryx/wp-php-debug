## wp-php-debug
Contributors: Keith Benedict <keith@benedicthome.com>
Stable tag: 0.1.0

This plugin is used to test code out on wordpress as required. Fair warning, this plugin is dangerous.  It is not meant for a production environment.

## Description 

The plugin has an options page which includes a textarea field where you can enter code and then execute it against the wordpress installation. I made this plugin after attempting to debug and work with issues on other code where I needed to test and debug but didnt want to have to modify, save, copy files repeatedly.  You can use this plugin to try out code then once refined place this code into your themes, plugins or other php files as required.

Do not use this on your production server, it uses the php eval statment and will run what you put in it, this means you can cause irreversible damage to your data, crash your site, or any number of world ending events as a result of leaving this on a produciton box.  

## Installation

Activate the plugin/include in functions.php, go to the settings/options page for PHP Debugger on your wordpress admin site and begin testing code.

## Changelog

* 0.1
	* Initial version, the basic form, eval and output.  

## TODO

* I want to consider options for a REPL editor window, syntax highlighting etc.. if possible.  There are third party libs I could include and attempt to add this but for now this is the quick and dirty "notepad" version.


