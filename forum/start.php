<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
USA
======================================================================*/

// Frameset for start page

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "http://".$HTTP_SERVER_VARS['HTTP_HOST'];
    $uri.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
    $uri.= "/logon.php?final_uri=";
    $uri.= urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    
    header_redirect($uri);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>:: teh forum ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="./styles/style.css" type="text/css">
	</head>
	<frameset rows="20,*" border="0">
          <frame src="./nav.php" name="nav" border="0" scrolling="no" marginwidth="0" marginheight="0" noresize>
          <frameset cols="250,*" border="1">
            <frame src="./start_left.php" name="left" border="1">
            <frame src="./start_main.php" name="right" border="1">
          </frameset>
        </frameset>
        
</html>
