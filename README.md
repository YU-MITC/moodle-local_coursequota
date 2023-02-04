# Course Quota local plugin for Moodle

Summary
------

This plugin allows Moodle system administrators to limit number of content (resources and activities) per course.
Teacher users will not be able to add new content to courses that exceed limit.
In corresponding courses, teacher users will see warning message.

By using course "shortname", system administrators can apply larger (smaller) limit to some courses than others.

In warning-only mode, this plugin displays the warning message about exceeding the limit, but does not prohibit addition of content.


Requirements
------

* PHP 7.3 or greater.
* Web browsers must support the JavaScript and HTML5.

Supported themes
-----

* Boost
* Classic

This plugin package might be able to work with other themes.

Installation
------

Unzip this plugin, and copy the directory (local/coursequota) under moodle root directory (ex. /moodle).
Installation will be completed after you log in as an administrator and access the notification menu.

Targeted Moodle versions
------

Moodle 3.9, 3.10, 3.11, 4.0, 4.1

Branches
------

* MOODLE_39_STABLE -> Moodle 3.9 branch
* MOODLE_310_STABLE -> Moodle 3.10 branch
* MOODLE_311_STABLE -> Moodle 3.11 branch
* MOODLE_400_STABLE -> Moodle 4.0 branch
* MOODLE_401_STABLE -> Moodle 4.1 branch

First clone the repository with "git clone", then "git checkout MOODLE_400_STABLE(branch name)" to switch branches.

Warning
------

* We are not responsible for any problem caused by this software. 
* This software follows the license policy of Moodle (GNU GPL v3).

Change log of Course Quota local plugin
------

Version 1.0.0

* first release.

