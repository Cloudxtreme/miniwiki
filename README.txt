MINIWIKI
========

Miniwiki is a tiny wiki that provides:

- An easy-to-use WYSIWYG editor, based on TinyMCE.
- Fast, database-less setup.
- Full customization of HTML and CSS.

LICENSE
=======

Apache 2 license.

SETUP INSTRUCTIONS
==================

Copy and extract the .zip file to your filesystem. The /data folder must be writable by Apache (chmod 0777). 

A .htaccess file is provided for clean URLs. Make sure you have "AllowOverride All" in your Apache configuration (httpd.conf). For more information, see: http://httpd.apache.org/docs/current/mod/core.html#allowoverride.

Examine config.inc.php to setup the wiki's name, and a username and password for signing in to the administration section (http://yoursite.com/admin).

TEMPLATES
=========

Templates can be customized in the templates folder. You'll want to look at page.inc.php, which is the template used for displaying all pages. You can provide custom templates for part of your website by using a folder structure. If you have a page under "documentation/general.html", you can create a "documentation.inc.php" template file in the templates folder. This will be used instead of page.inc.php.

AUTHORS
=======
Tom De Smedt <tomdesmedt@organisms.be>
