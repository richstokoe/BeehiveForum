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

/* $Id: ip.inc.php,v 1.10 2003-09-06 18:18:48 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/constants.inc.php");

function ip_check()
{
    global $HTTP_SERVER_VARS;

    $db_ip_banned = db_connect();

    if (!empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
      $ipaddress = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
    }else {
      $ipaddress = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    }

    $sql = "SELECT IP FROM ". forum_table("BANNED_IP"). " WHERE IP = '$ipaddress'";
    $result = db_query($sql, $db_ip_banned);

    if (db_num_rows($result) > 0) {
        if (!strstr(php_sapi_name(), 'cgi')) {
            header("HTTP/1.0 500 Internal Server Error");
        }else {
            echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
        }
        exit;
    }
}


function ban_ip($ipaddress)
{
   $db_ban_ip = db_connect();

   $sql = "INSERT INTO " . forum_table("BANNED_IP") . " (IP) VALUES ('$ipaddress')";
   $result = db_query($sql, $db_ban_ip);

   return $result;
}

function unban_ip($ipaddress)
{
   $db_ban_ip = db_connect();

   $sql = "DELETE FROM " . forum_table("BANNED_IP") . " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ban_ip);

   return $result;
}

function ip_is_banned($ipaddress)
{
   $db_ip_is_banned = db_connect();

   $sql = "SELECT IP FROM " . forum_table("BANNED_IP") . " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function get_ip_address()
{
    global $HTTP_SERVER_VARS;

    if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_X_FORWARDED'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_FORWARDED'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_FORWARDED'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_VIA'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_VIA'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_X_COMING_FROM'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_X_COMING_FROM'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_COMING_FROM'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_COMING_FROM'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_PROXY_CONNECTION'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_PROXY_CONNECTION'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
    }elseif (isset($HTTP_SERVER_VARS['HTTP_FROM'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_FROM'];
    }elseif (isset($HTTP_SERVER_VARS['CLIENT_IP'])) {
        $ipaddress = $HTTP_SERVER_VARS['CLIENT_IP'];
    }else {
        $ipaddress = $HTTP_SERVER_VARS['REMOTE_ADDR'];
    }

    if (preg_match("/^([0-9]{1,3}\.){3,3}[0-9]{1,3}/", $ipaddress, $matches)) {
        $ipaddress = $matches[1];
    }else {
        $ipaddress = "0.0.0.0";
    }

    return $ipaddress;
}

?>