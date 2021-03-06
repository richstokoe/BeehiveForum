<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Constant to define where the include files are
if (!defined('BH_INCLUDE_PATH')) {
    define('BH_INCLUDE_PATH', 'include/');
}

// Set the default timezone
date_default_timezone_set('UTC');

// Enable the error handler
require_once BH_INCLUDE_PATH. 'errorhandler.inc.php';

// Set the error reporting level to report all errors
error_reporting(E_ALL | E_STRICT);

// Register shutdown function to check for uncaught errors
register_shutdown_function('bh_shutdown_handler');

// Enable the exception handler
set_exception_handler('bh_exception_handler');

// Enable the error handler
set_error_handler('bh_error_handler');

// Don't output errors to the browser
ini_set('display_errors', '0');

// Fix problems with PHP and APC session storage
register_shutdown_function('session_write_close');

// Forum functionality
require_once BH_INCLUDE_PATH. 'forum.inc.php';

// Forum maintenance functionality
register_shutdown_function('forum_check_maintenance');

// Server checking functions
require_once BH_INCLUDE_PATH. 'server.inc.php';

// Caching functions
require_once BH_INCLUDE_PATH. 'cache.inc.php';

// Installation checking functions
require_once BH_INCLUDE_PATH. 'install.inc.php';

// Wordfilter
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Enable the word filter ob filter
ob_start('word_filter_ob_callback');

// Disable PHP's register_globals
unregister_globals();

// Disable PHP's magic quotes
disable_magic_quotes();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
require_once BH_INCLUDE_PATH. 'forum.inc.php';

// Initialise the session
session::init();

// Perform ban check
ban_check($_SESSION);

// Check to see if user account has been banned.
if (session::user_banned()) {
    light_html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session::user_approved()) {
    light_html_user_require_approval();
    exit;
}

// Get the webtag for the current forum
$webtag = get_webtag();

// Check we have a webtag and have access to the specified forum
if (!forum_check_webtag_available($webtag) || !forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("lforums.php?webtag_error");
}

?>