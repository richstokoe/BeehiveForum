<?php
// Beehive Constants

define("YEAR_IN_SECONDS",31536000);
define("DAY_IN_SECONDS", 86400);
define("HOUR_IN_SECONDS", 3600);

define("USER_PERM_SPLAT",1);
define("USER_PERM_WASP",2);
define("USER_PERM_WORM",4);
define("USER_PERM_WORKER",8);
define("USER_PERM_SOLDIER",16);
define("USER_PERM_QUEEN",32);

define("USER_FRIEND",1);
define("USER_IGNORED",2);
define("USER_IGNORED_SIG",4);

define("PERM_CHECK_WORKER",USER_PERM_WORKER|USER_PERM_SOLDIER|USER_PERM_QUEEN);
define("PERM_CHECK_SOLDIER",USER_PERM_SOLDIER|USER_PERM_QUEEN);

define("MAX_ATTACHMENT_SIZE", 5242880);

// Constants for Search Dialog Errors

define("SEARCH_USER_NOT_FOUND", 1);
define("SEARCH_NO_KEYWORDS", 2);

// Poll Constants

define("POLL_MULTIVOTE", 2);

?>
