<?php
require_once("./include/db.inc.php");
require_once("./include/format.inc.php");

function post_create($tid,$reply_pid,$fuid,$tuid,$content)
{
    $db = db_connect();
    $content = mysql_escape_string($content);
    
    $sql = "insert into POST (tid,reply_to_pid,from_uid,to_uid,created,content) ";
    $sql .= "values ($tid,$reply_pid,$fuid,$tuid,NOW(),\"$content\")";

    $result = db_query($sql,$db);

    if($result){
        $new_uid = db_insert_id($db);
        $sql = "update THREAD set length = length + 1, modified = NOW() ";
        $sql .= "where tid = $tid";
        $result = db_query($sql,$db);
    } else {
        $new_uid = -1;
    }

    db_disconnect($db);

    return $new_uid;
}

function post_create_thread($fid,$title)
{
    $db = db_connect();

    $sql = "insert into THREAD (fid,title,length,poll_flag,modified) ";
    $sql .= "values ($fid,\"$title\",0,\"N\",NOW())";

    $result = db_query($sql,$db);

    if($result){
        $new_tid = db_insert_id($db);
    } else {
        $new_tid = -1;
    }

    db_disconnect($db);

    return $new_tid;
}

function make_html($text)
{
    $html = stripslashes($text);
    $html = htmlentities($html,ENT_QUOTES);
    $html = format_url2link($html);
    $html = nl2br($html);

    return $html;
}

function post_draw_to_dropdown($default_uid)
{
    $html = "<select name=\"t_to_uid\">";
    $db = db_connect();

    if($default_uid){
        $sql = "select uid, logon, nickname FROM USER where uid = $default_uid";

       $result = db_query($sql,$db);

       if($row = db_fetch_array($result)){
           if(isset($row['logon'])){
               $logon = $row['logon'];
           } else {
             $logon = "";
           }
            if(isset($row['nickname'])){
                $nickname = $row['nickname'];
            } else {
                $nickname = "";
            }

            $fmt_uid = $row['uid'];
            $fmt_username = format_user_name($logon,$nickname);

            $html .= "<option value=\"$fmt_uid\">$fmt_username</option>";
        }
    }

    $html .= "<option value=\"0\">ALL</option>";

    $sql = "select uid, logon, nickname FROM USER";

    $result = db_query($sql,$db);

    $i = 0;
    while($row = db_fetch_array($result)){
        if($row['uid'] != $default_uid){
            if(isset($row['logon'])){
                $logon = $row['logon'];
            } else {
                $logon = "";
            }
            if(isset($row['nickname'])){
                $nickname = $row['nickname'];
            } else {
                $nickname = "";
            }

            $fmt_uid = $row['uid'];
            $fmt_username = format_user_name($logon,$nickname);

            $html .= "<option value=\"$fmt_uid\">$fmt_username</option>";
        }
    }

    db_disconnect($db);

    $html .= "</select>";
    return $html;
}

function is_valid_html($html)
{
    $html_parts = split('<[[:space:]]*|[[:space:]]*>', $html);

    $opentags = array();

    $valid = true;

    for($i=1; $i<count($html_parts); $i++){
        if($i%2){
            if(substr($html_parts[$i],0,1) == "/"){ // closing tag
                $tag = strtolower(substr($html_parts[$i],1));
                if(isset($opentags[$tag]) && $opentags[$tag] > 0){
                    $opentags[$tag]--;
                } else {
                    echo "<p>Tag $tag closed without being opened</p>";
                    $return = false;
                    break;
                }
            } else {
                if(substr($html_parts[$i],-1) != "/"){ // check for XHTML single tag
                    $bits = explode(" ", $html_parts[$i]);
                    $tag = strtolower($bits[0]);
                    if(!isset($opentags[$tag])){
                        $opentags[$tag] = 1;
                    } else {
                        $opentags[$tag]++;
                    }
                }
            }
        }
    }

    if($valid){
        $single_tags = array("br","img","hr","p");
        foreach($opentags as $tag => $n){
            if(!in_array($tag, $single_tags) && $n > 0){
                $valid = false;
            }
        }
    }
    return $valid;
}

?>
