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

require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");

function get_attachments($uid, $aid) {

    global $HTTP_SERVER_VARS;

    $userattachments = '';
    $userinfo = user_get($uid);
    
    $attachments_dir = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $userinfo['LOGON'];

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = '$uid' and AID = '$aid'";
    $result = db_query($sql, $db) or die(mysql_error());
    
    while($row = db_fetch_array($result)) {
    
      if (!is_array($userattachments)) $userattachments = array();
      
        if (file_exists($attachments_dir. '/'. $row['FILENAME'])) {
    
          $userattachments[] = array("filename" => $row['FILENAME'],
                                     "filesize" => filesize($attachments_dir. '/'. $row['FILENAME']));
        }else {
        
          delete_attachment($uid, $row['FILENAME']);
          
        }
                                 
    }
    
    return $userattachments;
    
}

function get_all_attachments($uid, $aid) {

    global $HTTP_SERVER_VARS;

    $userattachments = '';
    $userinfo = user_get($uid);
    
    $attachments_dir = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $userinfo['LOGON'];

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = '$uid' and AID <> '$aid'";
    $result = db_query($sql, $db) or die(mysql_error());
    
    while($row = db_fetch_array($result)) {
    
      if (!is_array($userattachments)) $userattachments = array();
      
        if (file_exists($attachments_dir. '/'. $row['FILENAME'])) {
    
          $userattachments[] = array("filename" => $row['FILENAME'],
                                     "filesize" => filesize($attachments_dir. '/'. $row['FILENAME']),
                                     "aid"      => $row['AID']);
                                     
        }else {
        
          delete_attachment($uid, $row['FILENAME']);
          
        }
                                 
    }
    
    return $userattachments;
    
}
    
function add_attachment($uid, $aid, $filename, $mimetype) {

    $db = db_connect();
    
    delete_attachment($uid, $filename); // Remove duplicate entries
    
    $sql = "insert into ". forum_table("POST_ATTACHMENT_FILES"). " (AID, UID, FILENAME, MIMETYPE) ";
    $sql.= "values ('$aid', '$uid', '$filename', '$mimetype')";
    
    $result = db_query($sql, $db) or die(mysql_error());
    
    return $result;
    
}

function delete_attachment($uid, $filename) {

    $db = db_connect();
    
    $sql = "delete from ". forum_table("POST_ATTACHMENT_FILES"). " where UID = '$uid' ";
    $sql.= "and FILENAME = '$filename'";
    
    $result = db_query($sql, $db) or die(mysql_error());
    
    return $result;
    
}

function move_attachment($uid, $aid, $filename) {

    $db = db_connect();
    
    $sql = "update ". forum_table("POST_ATTACHMENT_FILES"). " set AID = '$aid' ";
    $sql.= "where UID = '$uid' and FILENAME = '$filename'";
    
    $result = db_query($sql, $db) or die(mysql_error());
    
    return result;
    
}

function get_free_attachment_space($uid) {

    global $HTTP_SERVER_VARS;

    $userinfo = user_get($uid);
    $attachments_dir = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $userinfo['LOGON'];
                       
    if ($dir = opendir($attachments_dir)) {
    
      while (($file = readdir($dir)) !== false) {
        $used_attachment_space += filesize($attachments_dir. '/'. $file);
      }

      closedir($dir);
    }

    return MAX_ATTACHMENT_SIZE - $used_attachment_space;                      
}

function get_attachment_id($tid, $pid) {

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_IDS"). " where TID = $tid AND PID = $pid";
    $result = db_query($sql, $db);
    
    if (db_num_rows($result) > 0) {
    
      $attachment = db_fetch_array($result);
      return $attachment['AID'];
      
    }else{
    
      return -1;
      
    }
    
}

function get_message_tidpid($aid) {

    $db = db_connect();
    
    $sql = "select * from ". forum_table("POST_ATTACHMENT_IDS"). " where AID = '$aid'";
    $result = db_query($sql, $db);
    
    if (db_num_rows($result) > 0) {
    
      $tidpid = db_fetch_array($result);
      return $tidpid['TID']. ".". $tidpid['PID'];
      
    }else{
    
      return "";
      
    }
    
}

function download_attachment($uid, $filename) {

    global $HTTP_SERVER_VARS;

    $userinfo = user_get($uid);
    
    $attachments_dir = dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']). '/attachments/'. $userinfo['LOGON'];
                       
    if (file_exists($attachments_dir. '/'. $filename)) {
    
      header("Content-Type: application/x-ms-download");
      header("Content-Length: ". filesize($attachments_dir. '/'. $filename));
      header("Content-disposition: filename=". $filename);
      header("Content-Transfer-Encoding: binary");
      header("Pragma: no-cache");
      header("Expires: 0");

      readfile($attachments_dir. '/'. $filename);
      
    }
       
}

?>