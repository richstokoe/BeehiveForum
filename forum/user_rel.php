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

/* $Id: user_rel.php,v 1.45 2004-04-23 22:11:57 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_rel.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
        html_guest_error();
        exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
    $msg = $_POST['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

if (isset($_GET['edit_rel']) && is_numeric($_GET['edit_rel'])) {
    $edit_rel = true;
}elseif (isset($_POST['edit_rel']) && is_numeric($_POST['edit_rel'])) {
    $edit_rel = true;
}else {
    $edit_rel = false;
}

$my_uid = bh_session_get_value('UID');

if (isset($_POST['submit'])) {

    $rel = isset($_POST['rel']) ? $_POST['rel'] : 0;
    $rel+= isset($_POST['sig']) ? $_POST['sig'] : 0;

    $sig_global = isset($_POST['sig_global']) ? $_POST['sig_global'] : '';

    user_rel_update($my_uid, $_POST['uid'], $rel);

    user_update_global_sig($my_uid, $sig_global);

    // Update the User's Session to save them having to logout and back in
    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?webtag=$webtag&msg=$msg");
}

if (isset($_POST['cancel'])) {
    if ($edit_rel) {
        header_redirect("./edit_relations.php?webtag=$webtag");
    }else {
        header_redirect("./messages.php?webtag=$webtag&msg=$msg");
    }
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
    if (!$user = user_get($uid)) {
        html_draw_top();
        echo "<h1>{$lang['error']}:</h1>";
        echo "<p>{$lang['invalidusername']}</p>";
        html_draw_bottom();
        exit;
    }
    $uname = "<a href=\"javascript:void(0);\" onclick=\"openProfile($uid, '$webtag')\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']) ."</a>";
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<p>{$lang['nouserspecified']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top("openprofile.js");

$rel = user_rel_get($my_uid, $uid);

echo "<h1>{$lang['userrelationship']}: $uname</h1>\n";
echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"relationship\" action=\"user_rel.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
echo "    ", form_input_hidden("uid", $uid), "\n";
echo "    ", form_input_hidden("msg", $msg), "\n";
echo "    ", form_input_hidden("edit_rel", $edit_rel), "\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";

if (isset($uid)) {

    echo "                  <tr>\n";
    echo "                    <td class=\"subhead\" colspan=\"2\">{$lang['relationship']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "1", $lang['friend'], $rel & USER_FRIEND ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['friend_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "0", $lang['normal'], !(($rel & USER_IGNORED) || ($rel & USER_FRIEND)) ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['normal_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "2", $lang['ignored'], $rel & USER_IGNORED ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['ignore_exp']}</td>\n";
    echo "                  </tr>\n";
}

echo "                  <tr>\n";
echo "                    <td class=\"subhead\" colspan=\"2\">{$lang['signature']}</td>\n";
echo "                  </tr>\n";

if (isset($uid)) {

    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("sig", "0", $lang['display'], $rel ^ USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['displaysig_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("sig", "4", $lang['ignore'], $rel & USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['hidesig_exp']}</td>\n";
    echo "                  </tr>\n";
}

echo "                  <tr>\n";
echo "                    <td width=\"130\">", form_checkbox("sig_global", "Y", $lang['globallyignored'], user_get_global_sig(bh_session_get_value('UID')) == "Y"), "</td>\n";
echo "                    <td width=\"370\">: {$lang['globallyignoredsig_exp']}</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>