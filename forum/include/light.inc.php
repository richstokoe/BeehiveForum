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

// Functions for the very stripped-down "light" version of Beehive

function light_html_draw_top ($title = false)
{

    global $forum_name;

    if(!$title){
        $title = $forum_name;
    }

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
	echo "\t<head>\n";
	echo "\t\t<title>$title</title>\n";
	echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"/>\n";
	echo "\t</head>\n";
	echo "\t<body>\n";
}

function light_html_draw_bottom ()
{
    echo "\t</body>\n";
	echo "</html>\n";
}

// create a <select> dropdown with values from array(s)
function light_form_dropdown_array($name, $value, $label, $default = "")
{
    $html = "<select name=\"$name\">";

    for($i=0;$i<count($value);$i++){
        $sel = ($value[$i] == $default) ? " selected" : "";
        if($label[$i]){
            $html.= "<option value=\"".$value[$i]."\"$sel>".$label[$i]."</option>";
        } else {
            $html.= "<option$sel>".$value[$i]."</option>";
        }
    }
    return $html."</select>";
}

// create a <input type="submit"> button
function light_form_submit($name = "submit", $value = "Submit")
{
    return "<input type=\"submit\" name=\"$name\" value=\"$value\" />";
}

function light_poll_confirm_close($tid)
{

    global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;
    
    if($HTTP_COOKIE_VARS['bh_sess_uid'] != $preview_message['FROM_UID'] && !perm_is_moderator()) {
        edit_refuse();
        return;
    }    
    
    $preview_message = messages_get($tid, 1, 1);
    
    if($preview_message['TO_UID'] == 0) {
    
        $preview_message['TLOGON'] = "ALL";
        $preview_message['TNICK'] = "ALL";
        
    }else {
    
        $preview_tuser = user_get($preview_message['TO_UID']);
        $preview_message['TLOGON'] = $preview_tuser['LOGON'];
        $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        
    }
    
    $preview_fuser = user_get($preview_message['FROM_UID']);
    $preview_message['FLOGON'] = $preview_fuser['LOGON'];
    $preview_message['FNICK'] = $preview_fuser['NICKNAME'];
    
    echo "<h2>Are you sure you want to close the following Poll?</h2>\n";
    
    light_poll_display($tid, $preview_message, 0, 0, false);
    
    echo "<p><form name=\"f_delete\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">";
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo light_form_submit("pollclose", "End Poll");
    echo "&nbsp;".light_form_submit("cancel", "Cancel");
    echo "</form>\n";

}

function light_messages_top($foldertitle, $threadtitle, $interest_level = 0)
{
    echo "<h2>$foldertitle: $threadtitle";
    if ($interest_level == 1) echo "&nbsp;(High Interest)";
    if ($interest_level == 2) echo "&nbsp;(Subscribed)";
    echo "</h2>";
}

function light_form_radio($name, $value, $text, $checked = false)
{
    $html = "<input type=\"radio\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text</span>";
}

function light_poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true)
{

    global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes   = 0;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {
      $totalvotes = $totalvotes + $pollresults[$i]['VOTES'];
    }

    $polldata['CONTENT'].= "<form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" target=\"_self\">\n";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "<h2>". thread_get_title($tid). "</h2>\n";

    $max_value = 0;

    for ($i = 1; $i <= sizeof($pollresults); $i++) {

      if (!empty($pollresults[$i]['OPTION_NAME'])) {

        if ($pollresults[$i]['VOTES'] > $max_value) $max_value = $pollresults[$i]['VOTES'];
        $optioncount++;

      }

    }

    if ($in_list) {

      if ((!isset($userpolldata['OPTION_ID']) && $HTTP_COOKIE_VARS['bh_sess_uid'] > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > gmmktime())) {

        for ($i = 1; $i <= sizeof($pollresults); $i++) {

          if (!empty($pollresults[$i]['OPTION_NAME'])) {

            $polldata['CONTENT'].= light_form_radio("pollvote", $pollresults[$i]['OPTION_ID'], '', false). "&nbsp;". $pollresults[$i]['OPTION_NAME']. "<br />\n";

          }

        }

      }else {

        if ($polldata['SHOWRESULTS'] == 1) {

          for ($i = 1; $i <= sizeof($pollresults); $i++) {

              $polldata['CONTENT'] .= $pollresults[$i]['OPTION_NAME'] . ": " . $pollresults[$i]['VOTES'] . " votes <br />\n";

          }

        }else {

          for ($i = 1; $i <= sizeof($pollresults); $i++) {

            if (!empty($pollresults[$i]['OPTION_NAME'])) {

              $polldata['CONTENT'].= $pollresults[$i]['OPTION_NAME']. "<br />\n";

            }

          }

        }

      }

    }else {

      for ($i = 1; $i <= sizeof($pollresults); $i++) {

        if (!empty($pollresults[$i]['OPTION_NAME'])) {

          $polldata['CONTENT'].= $pollresults[$i]['OPTION_NAME']. "<br />\n";

        }

      }

    }

    if ($in_list) {
    
    $polldata['CONTENT'] .= "<p>";

      if ($totalvotes == 0 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>Nobody voted.</b>";

      }elseif ($totalvotes == 0 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>Nobody has voted.</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>1 person voted.</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>1 person has voted.</b>";

      }else {

        if ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) {

          $polldata['CONTENT'].= "<b>". $totalvotes. " people voted.</b>";

        }else {

          $polldata['CONTENT'].= "<b>". $totalvotes. " people have voted.</b>";

        }

      }

      $polldata['CONTENT'].= "</p>\n";

      if (($polldata['CLOSES'] <= gmmktime()) && $polldata['CLOSES'] != 0) {

        $polldata['CONTENT'].= "<p>Poll has ended.</p>\n";

        if (isset($userpolldata['OPTION_ID'])) {
          $polldata['CONTENT'].= "<p>Your vote was '". $pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME']. "' on ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</p>\n";
        }

      }else {

        if (isset($userpolldata['OPTION_ID'])) {

          $polldata['CONTENT'].= "<p>Your vote was '". $pollresults[$userpolldata['OPTION_ID']]['OPTION_NAME']. "' on ". gmdate("jS M Y", $userpolldata['TSTAMP']). ".</p>\n";

        }elseif ($HTTP_COOKIE_VARS['bh_sess_uid'] > 0) {


          $polldata['CONTENT'].= "<p>". light_form_submit('pollsubmit', 'Vote'). "</p>\n";


        }

      }

    }

    // Work out what relationship the user has to the user who posted the poll
    $polldata['FROM_RELATIONSHIP'] = user_rel_get($HTTP_COOKIE_VARS['bh_sess_uid'], $polldata['FROM_UID']);

    light_message_display($tid, $polldata, $msg_count, $first_msg, $in_list, $closed, $limit_text, true);

}

function light_message_display($tid, $message, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = false, $show_sigs = true)
{

    global $HTTP_SERVER_VARS, $HTTP_COOKIE_VARS, $maximum_post_length, $attachment_dir;

    if(!isset($message['CONTENT']) || $message['CONTENT'] == "") {
        light_message_display_deleted($tid, $message['PID']);
        return;
    }

    if ($HTTP_COOKIE_VARS['bh_sess_uid'] != $message['FROM_UID']) {
      if ((user_get_status($message['FROM_UID']) & USER_PERM_WORM) && !perm_is_moderator()) {
        light_message_display_deleted($tid, $message['PID']);
	return;
      }
    }

    if(!isset($message['FROM_RELATIONSHIP'])) {
        $message['FROM_RELATIONSHIP'] = 0;
    }
    if(!isset($message['TO_RELATIONSHIP'])) {
        $message['TO_RELATIONSHIP'] = 0;
    }

    if((strlen($message['CONTENT']) > $maximum_post_length) && $limit_text && !$is_poll) {
        $message['CONTENT'] = fix_html(substr($message['CONTENT'], 0, $maximum_post_length));
        $message['CONTENT'].= "...[Message Truncated]\n<p align=\"center\"><a href=\"./display.php?msg=". $tid. ".". $message['PID']. "\" target=\"_self\">View full message.</a>";
    }

    if($in_list){
        echo "<a name=\"a". $tid. "_". $message['PID']. "\"></a>";
    }

    // OUTPUT MESSAGE ----------------------------------------------------------

    echo "<p><b>From: " . format_user_name($message['FLOGON'], $message['FNICK'])."</b>";

    // If the user posting a poll is ignored, remove ignored status for this message only so the poll can be seen
    if ($is_poll && $message['PID'] == 1 && ($message['FROM_RELATIONSHIP'] & USER_IGNORED)) {
        $message['FROM_RELATIONSHIP'] -= USER_IGNORED;
        $temp_ignore = true;
    }

    if($message['FROM_RELATIONSHIP'] & USER_FRIEND) {
        echo "&nbsp;(Friend) ";
    } else if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) || $temp_ignore) {
        echo "&nbsp;(Ignored user) ";
    }

    if(($message['FROM_RELATIONSHIP'] & USER_IGNORED) && $limit_text) {
        echo "<b>Ignored message</b>";
    } else {
        if($in_list) {
            $user_prefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);
	    if ((user_get_status($message['FROM_UID']) & USER_PERM_WORM)) echo "<b>Wormed User</b> ";
	    if ($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) echo "<b>Ignored signature</b> ";
            echo "&nbsp;".format_time($message['CREATED'], 1)."<br />";
        }
    }

    if(($message['TLOGON'] != "ALL") && $message['TO_UID'] != 0) {

        echo "<b>To: " . format_user_name($message['TLOGON'], $message['TNICK'])."</b>";

        if($message['TO_RELATIONSHIP'] & USER_FRIEND) {
            echo "&nbsp;(Friend)";
        } else if($message['TO_RELATIONSHIP'] & USER_IGNORED) {
            echo "&nbsp;(Ignored user)";
        }

        if($message['VIEWED'] > 0) {
            echo "&nbsp;".format_time($message['VIEWED'], 1);
        } else {
            echo "&nbsp;unread";
        }
    }else {
        echo "<b>To: ALL</b>";
    }

    echo "</p>\n";


    echo "<p><i>Message ".$message['PID'] . " of " . $msg_count."</i></p>\n";

        if (($message['FROM_RELATIONSHIP'] & USER_IGNORED_SIG) || !$show_sigs) {
            $msg_split = preg_split("/<div class=\"sig\">/", $message['CONTENT']);
            $tmp_sig = preg_split('/<\/div>/', $msg_split[count($msg_split)-1]);
            $msg_split[count($msg_split)-1] = $tmp_sig[count($tmp_sig)-1];
            $message['CONTENT'] = "";
            for ($i=0; $i<count($msg_split); $i++) {
                if ($i > 0) $message['CONTENT'] .= "<div class=\"sig\">";
                $message['CONTENT'] .= $msg_split[$i];
            }
            $message['CONTENT'] .= "</div>";
	}

        echo "<p>". $message['CONTENT']. "</p>\n";


        echo "<p>\n";

        if($in_list && $limit_text != false){
            if(!($closed || ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_WASP))) {

                echo "<a href=\"lpost.php?replyto=$tid.".$message['PID']."\">Reply</a>";

            }


        }
        echo "</p>\n";
        echo "<hr />";
}

function light_message_display_deleted($tid,$pid)
{

    echo "<p>Message ${tid}.${pid} was deleted</p>\n";
    echo "<hr />";

}

function light_messages_nav_strip($tid,$pid,$length,$ppp)
{

    // Less than 20 messages, no nav needed
    if($pid == 1 && $length < $ppp){
        return;
    }

    // Modulus to get base for links, e.g. ppp = 20, pid = 28, base = 8
    $spid = $pid % $ppp;

    // The first section, 1-x
    if($spid > 1){
        if($pid > 1){
            $navbits[0] = "<a href=\"lmessages.php?msg=$tid.1\">" . mess_nav_range(1,$spid-1) . "</a>";
        } else {
            $c = 0;
            $navbits[0] = mess_nav_range(1,$spid-1); // Don't add <a> tag for current section
        }
        $i = 1;
    } else {
        $i = 0;
    }

    // The middle section(s)
    while($spid + ($ppp - 1) <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$spid+($ppp - 1)); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?msg=$tid.$spid\">" . mess_nav_range($spid==0 ? 1 : $spid,$spid+($ppp - 1)) . "</a>";
        }
        $spid += $ppp;
        $i++;
    }

    // The final section, x-n
    if($spid <= $length){
        if($spid == $pid){
            $c = $i;
            $navbits[$i] = mess_nav_range($spid,$length); // Don't add <a> tag for current section
        } else {
            $navbits[$i] = "<a href=\"lmessages.php?msg=$tid.$spid\">" . mess_nav_range($spid,$length) . "</a>";
        }
    }
    $max = $i;

    $html = "Show messages:";

    if($length <= $ppp){
        $html .= " <a href=\"lmessages.php?msg=$tid.1\">All</a>\n";
    }

    for($i=0;$i<=$max;$i++){
        // Only display first, last and those within 3 of the current section
        //echo "$i : $max\n";
        if((abs($c - $i) < 4) || $i == 0 || $i == $max){
            $html .= "\n&nbsp;" . $navbits[$i];
        } else if(abs($c - $i) == 4){
            $html .= "\n&nbsp;...";
        }
    }

    unset($navbits);

    echo "<p align=\"center\">" . $html . "</p>\n";
}

function light_html_guest_error ()
{ 
     light_html_draw_top();
     echo "<h1>Sorry, you need to be logged in to use this feature.</h1>"; 
     light_html_draw_bottom();
}

function light_folder_draw_dropdown($default_fid,$field_name="t_fid",$suffix="")
{
    global $HTTP_COOKIE_VARS;
    $ustatus = $HTTP_COOKIE_VARS['bh_sess_ustatus'];
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & PERM_CHECK_WORKER){
        $sql = "select FID, TITLE from ".forum_table("FOLDER");
    } else {
        $sql = "select DISTINCT F.FID, F.TITLE from ".forum_table("FOLDER")." F left join ";
        $sql.= forum_table("USER_FOLDER")." UF on (UF.FID = F.FID and UF.UID = '$uid') ";
        $sql.= "where (F.ACCESS_LEVEL = 0 or (F.ACCESS_LEVEL = 1 AND UF.ALLOWED <=> 1))";
    }

    return form_dropdown_sql($field_name.$suffix, $sql, $default_fid);
}

function light_form_dropdown_sql($name, $sql, $default)
{
    $html = "<select name=\"$name\">";

    $db_form_dropdown_sql = db_connect();

    $result = db_query($sql, $db_form_dropdown_sql);

    while($row = db_fetch_array($result)){
        $sel = ($row[0] == $default) ? " selected" : "";
        if($row[1]){
            $html.= "<option value=\"".$row[0]."\"$sel>".$row[1]."</option>";
        } else {
            $html.= "<option$sel>".$row[0]."</option>";
        }
    }

    return $html."</select>";
}

function light_form_textarea($name, $value = "", $rows = 0, $cols = 0)
{
    $html = "<textarea name=\"$name\" ";

    if($rows) $html.= " rows=\"$rows\"";
    if($cols) $html.= " cols=\"$cols\"";

    $html .= ">$value</textarea>";

    return $html;
}

function light_form_checkbox($name, $value, $text, $checked = false)
{
    $html = "<input type=\"checkbox\" name=\"$name\" value=\"$value\"";
    if($checked) $html .= " checked";
    return $html . " />$text";
}

function light_form_field($name, $value = "", $width = 0, $maxchars = 0, $type = "text")
{
    $html = "<input type=\"$type\" name=\"$name\"";
    $html.= " value=\"$value\"";
    
    if($width) $html.= " size=\"$width\"";
    if($maxchars) $html.= " maxchars=\"$maxchars\"";

    return $html.">";
}

function light_form_input_text($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"text");
}

function light_form_input_password($name, $value = "", $width = 0, $maxchars = 0)
{
    return light_form_field($name,$value,$width,$maxchars,"password");
}
?>
