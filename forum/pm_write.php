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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");
require_once("./include/email.inc.php");
require_once("./include/attachments.inc.php");

// Get the Message ID (MID)

if (isset($HTTP_GET_VARS['replyto']))  $mid = $HTTP_GET_VARS['replyto'];
if (isset($HTTP_POST_VARS['replyto'])) $mid = $HTTP_POST_VARS['replyto'];

// User clicked cancel

if (isset($HTTP_POST_VARS['cancel'])) {
    if (isset($mid)) {
        $uri = "./pm.php?mid=$mid";
    }else {
        $uri = "./pm.php";
    }
    header_redirect($uri);
}

// Assume everything is correct (form input, etc)

$valid = true;

// Check to see if the PM is a reply and modify the subject line

if (isset($mid)) {

    $db = db_connect();

    $sql = "select FROM_UID, SUBJECT from ". forum_table("PM"). " where MID = '$mid'";
    $result = db_query($sql, $db);

    if (db_num_rows($result) > 0) {

        $resultarray = db_fetch_array($result);
        $t_subject = $resultarray['SUBJECT'];

        if (!isset($HTTP_POST_VARS['t_subject']) || trim($HTTP_POST_VARS['t_subject']) == "") {
            $t_subject = $resultarray['SUBJECT'];
            if (strtoupper(substr($t_subject, 0, 3)) != "RE:") {
                $t_subject = "RE:". $t_subject;
            }
        }

    }
}

// HTML tickbox

if (isset($HTTP_POST_VARS['t_post_html'])) {
    $t_post_html = "Y";
}

// Fetch the TO_UID value

if (isset($HTTP_POST_VARS['t_to_uid'])) {
    $t_to_uid = $HTTP_POST_VARS['t_to_uid'];
}elseif (isset($mid)) {
    $t_to_uid = pm_get_user($mid);
}else {
    $t_to_uid = -1;
}

// 'Other' Button was used to specify a username

if (substr($t_to_uid, 0, 2) == "U:") {

    $u_login = substr($HTTP_POST_VARS['t_to_uid'], 2);

    $db = db_connect();
    $sql = "select UID from ". forum_table("USER"). " where LOGON = '" . $u_login. "'";

    $result = db_query($sql,$db);

    if (db_num_rows($result) > 0) {

        $touser = db_fetch_array($result);
        $t_to_uid = $touser['UID'];

    }else{

        $error_html = "<h2>{$lang['invalidusername']}</h2>";
        $valid = false;

    }

}

// User clicked the submit button - check the data that was submitted

if (isset($HTTP_POST_VARS['submit']) || isset($HTTP_POST_VARS['preview'])) {

    if (isset($HTTP_POST_VARS['t_subject']) && trim($HTTP_POST_VARS['t_subject']) != "") {
        $t_subject = trim($HTTP_POST_VARS['t_subject']);
    }else {
        $error_html = "<h2>{$lang['entersubjectformessage']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['t_content']) && trim($HTTP_POST_VARS['t_content']) != "") {
        $t_content = $HTTP_POST_VARS['t_content'];
    }else {
        $error_html = "<h2>{$lang['entercontentformessage']}</h2>";
        $valid = false;
    }
}

// Required variables - make sure they are initialised

$t_content = isset($t_content) ? _stripslashes($t_content) : "";
$t_subject = isset($t_subject) ? _stripslashes($t_subject) : "";
$t_post_html = isset($t_post_html) ? $t_post_html : "";

// Process the data based on what we know.

if ($valid) {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = fix_html($t_content);
    }

}else {

    if (isset($t_post_html) && $t_post_html == "Y") {
        $t_content = _stripslashes($t_content);
    }
}


// Send the PM

if ($valid && isset($HTTP_POST_VARS['submit'])) {
    if ($new_mid = pm_send_message($t_to_uid, $t_subject, $t_content)) {
        if (isset($HTTP_POST_VARS['aid']) && get_num_attachments($HTTP_POST_VARS['aid']) > 0) {
            pm_save_attachment_id($new_mid, $HTTP_POST_VARS['aid']);
        }
        email_send_pm_notification($t_to_uid, $new_mid, bh_session_get_value('UID'));
        if (isset($mid)){
            $uri = "./pm.php?mid=$mid";
        }else {
            $uri = "./pm.php";
        }
        header_redirect($uri);
    }else {
        $error_html = "<h2>{$lang['errorcreatingpm']}</h2>";
        $valid = $false;
    }
}

html_draw_top_script();
draw_header_pm();

// Attachment Unique ID

if (!isset($HTTP_POST_VARS['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $HTTP_POST_VARS['aid'];
}

// User clicked the Convert button.

if ($valid && isset($HTTP_POST_VARS['convert_html'])) {

   $t_content = nl2br(_htmlentities(_stripslashes($t_content)));
   $t_post_html = "Y";

}

// preview message

if ($valid && isset($HTTP_POST_VARS['preview'])) {

    echo "<h1>{$lang['privatemessages']}: {$lang['messagepreview']}</h1>\n";
    echo "<br />\n";

    if ($HTTP_POST_VARS['t_to_uid'] == 0) {

        $pm_elements_array['LOGON'] = "ALL";
        $pm_elements_array['NICKNAME'] = "ALL";
        $pm_elements_array['FROM_UID'] = 0;

    }else{

        $preview_tuser = user_get($HTTP_POST_VARS['t_to_uid']);
        $pm_elements_array['LOGON'] = $preview_tuser['LOGON'];
        $pm_elements_array['NICKNAME'] = $preview_tuser['NICKNAME'];
        $pm_elements_array['FROM_UID'] = $preview_tuser['UID'];

    }

    $pm_elements_array['SUBJECT'] = $t_subject;
    $pm_elements_array['CREATED'] = mktime();
    $pm_elements_array['AID'] = $aid;

    if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
        $pm_elements_array['CONTENT'] = make_html($t_content);
    }else {
        $pm_elements_array['CONTENT'] = $t_content;
    }

    draw_pm_message($pm_elements_array);
    echo "<br />\n";

}

echo "<h1>{$lang['privatemessages']}: {$lang['writepm']}</h1>\n";
echo "<div align=\"right\"><a href=\"pm.php\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm.php?folder=1\" target=\"_self\">{$lang['pmsentitems']}</a> | <a href=\"pm.php?folder=2\" target=\"_self\">{$lang['pmoutbox']}</a> | <a href=\"pm.php?folder=3\" target=\"_self\">{$lang['pmsaveditems']}</a></div><br />\n";

if ($valid == false) {
    echo $error_html;
}

if (!isset($t_post_html) || (isset($t_post_html) && $t_post_html != "Y")) {
    $t_content = isset($t_content) ? _stripslashes($t_content) : "";
}

echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
echo "          <td>", form_field("t_subject", isset($t_subject) ? stripslashes(_htmlentities($t_subject)) : "", 32), "&nbsp;", form_submit("submit", $lang['post']), "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td align=\"right\">{$lang['to']}: </td>\n";
echo "          <td>", pm_draw_to_dropdown($t_to_uid), "&nbsp;", form_button("others", $lang['others'], "onclick=\"javascript:launchOthers()\""), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "      <table border=\"0\" class=\"posthead\">\n";
echo "        <tr>\n";
echo "          <td>".form_textarea("t_content", isset($t_content) ? _htmlentities($t_content) : "", 15, 85). "</td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td><span class=\"bhinputcheckbox\">", form_checkbox('t_post_html', 'Y', $lang['messagecontainsHTML'], ($t_post_html == 'Y')), "</td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo form_submit('submit', $lang['post']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
echo form_submit('submit', $lang['cancel']);

if ($attachments_enabled && $pm_allow_attachments) {
    echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>".form_button("attachments", $lang['attachments'], "onclick=\"attachwin = window.open('attachments.php?aid=". $aid. "', 'attachments', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
    echo form_input_hidden("aid", $aid);
}

echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>".form_submit("convert_html", $lang['converttoHTML']);
echo "</form>\n";


if (isset($mid)) {

    $pm_elements_array = pm_single_get($mid, 0, bh_session_get_value('TO_UID'));
    echo "<p>in reply to:</p>";
    draw_pm_message($pm_elements_array);

}

html_draw_bottom ();

?>