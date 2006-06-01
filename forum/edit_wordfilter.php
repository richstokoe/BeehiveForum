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

/* $Id: edit_wordfilter.php,v 1.51 2006-06-01 16:29:07 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

html_draw_top();

$uid = bh_session_get_value('UID');

if (isset($_POST['submit'])) {

    user_clear_word_filter();

    $filter_count = 0;

    if (isset($_POST['match']) && is_array($_POST['match'])) {

        foreach ($_POST['match'] as $key => $match_text) {

            $match_text = _stripslashes($match_text);

            if ($filter_count < 20) {

                $replace_text  = (isset($_POST['replace'][$key])) ? _stripslashes($_POST['replace'][$key]) : "";
                $filter_option = (isset($_POST['filter_option'][$key])) ? $_POST['filter_option'][$key] : 0;

                if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $match_text)) {

                    $match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $match_text);
                }

                user_add_word_filter($match_text, $replace_text, $filter_option);
            }

            $filter_count++;
        }
    }

    if (isset($_POST['new_match']) && strlen(trim(_stripslashes($_POST['new_match']))) > 0 && $filter_count < 20) {

        $match_text = trim(_stripslashes($_POST['new_match']));

        $replace_text  = (isset($_POST['new_replace'])) ? _stripslashes($_POST['new_replace']) : "";
        $filter_option = (isset($_POST['new_filter_option'])) ? $_POST['new_filter_option'] : 0;

        if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $match_text)) {

            $match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $match_text);
        }

        user_add_word_filter($match_text, $replace_text, $filter_option);
    }

    if (isset($_POST['use_admin_filter']) && $_POST['use_admin_filter'] == "Y") {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }

    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    user_update_prefs($uid, $user_prefs, $user_prefs_global);

    if (!isset($status_text)) $status_text = "<p><b>{$lang['wordfilterupdated']}</b></p>";

}elseif (isset($_POST['delete'])) {

    list($id) = array_keys($_POST['delete']);
    user_delete_word_filter($id);
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

if (!isset($user_prefs['USE_ADMIN_FILTER'])) $user_prefs['USE_ADMIN_FILTER'] = 'N';

// Get Word Filter

$word_filter_array = user_get_word_filter();

echo "<h1>{$lang['editwordfilter']}</h1>\n";

if (isset($status_text)) echo $status_text;

echo "<p>{$lang['wordfilterexp_3']}</p>\n";
echo "<p>{$lang['wordfilterexp_2']}</p>\n";

echo "<form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['matchedtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['replacementtext']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['all']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['wholeword']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" nowrap=\"nowrap\">&nbsp;{$lang['preg']}&nbsp;</td>\n";
echo "                  <td class=\"subhead\" width=\"75\">&nbsp;</td>\n";
echo "                </tr>\n";

foreach ($word_filter_array as $key => $word_filter) {

    echo "                <tr>\n";

    if ($word_filter['UID'] == 0) {

        if (!forum_get_setting('admin_force_word_filter', 'Y')) {

            echo "                  <td align=\"center\">&nbsp;<sup>[A]</sup></td>\n";
            echo "                  <td>", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), "</td>\n";
            echo "                  <td>", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), "</td>\n";
            echo "                  <td>&nbsp;</td>\n";
        }

    }else {

        echo "                  <td>&nbsp;</td>\n";
        echo "                  <td>", form_input_text("match[$key]", _htmlentities(_stripslashes($word_filter['MATCH_TEXT'])), 30), "</td>\n";
        echo "                  <td>", form_input_text("replace[$key]", _htmlentities(_stripslashes($word_filter['REPLACE_TEXT'])), 30), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "0", "", $word_filter['FILTER_OPTION'] == 0), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "1", "", $word_filter['FILTER_OPTION'] == 1), "</td>\n";
        echo "                  <td align=\"center\">", form_radio("filter_option[$key]", "2", "", $word_filter['FILTER_OPTION'] == 2), "</td>\n";
        echo "                  <td align=\"center\">", form_submit("delete[$key]", $lang['delete']), "</td>\n";
    }

    echo "                </tr>\n";
}

if (sizeof($word_filter_array) < 20) {

    echo "                <tr>\n";
    echo "                  <td>&nbsp;{$lang['newcaps']}</td>\n";
    echo "                  <td>", form_input_text("new_match", "", 30), "</td>\n";
    echo "                  <td>", form_input_text("new_replace", "", 30), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "0", "", true), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "1", "", false), "</td>\n";
    echo "                  <td align=\"center\">", form_radio("new_filter_option", "2", "", false), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td colspan=\"6\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td valign=\"top\">&nbsp;</td>\n";
    echo "                  <td colspan=\"6\">{$lang['wordfilterisfull']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['options']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "</td>\n";
echo "                      </tr>\n";

if (!forum_get_setting('admin_force_word_filter', 'Y')) {

    echo "                      <tr>\n";
    echo "                        <td>", form_checkbox("use_admin_filter", "Y", $lang['includeadminfilter'], (isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y')), "</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <p>{$lang['word_filter_help_1']}</p>\n";
echo "  <p>{$lang['word_filter_help_2']}</p>\n";
echo "  <p>{$lang['word_filter_help_3']}</p>\n";
echo "</form>\n";

html_draw_bottom();

?>