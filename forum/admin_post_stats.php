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

/* $Id: admin_post_stats.php,v 1.1 2004-12-19 13:20:32 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/html.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_profile.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h2>{$lang['loggedinsuccessfully']}</h2>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

if (!perm_has_forumtools_access()) {
    html_draw_top();
    echo "<h2>{$lang['accessdenied']}</h2>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['doreport'])) {

    html_draw_top("robots=noindex,nofollow");

    echo "  <h1>{$lang['admin']}: {$lang['postingstats']}</h1>\n";
    echo "  <br />\n";
    echo "  <h2>{$lang['top10postersforthismonth']}</h2>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['totalposts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['posts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['percentofthismonthsposts']}</td>\n";
    echo "                </tr>\n";

    $user_stats_array = get_month_post_tallys();

    if (sizeof($user_stats_array['user_stats']) > 0) {

        foreach ($user_stats_array['user_stats'] as $user_stats) {

            echo "                <tr>\n";
            echo "                  <td>", format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']), "</td>\n";
            echo "                  <td>", user_get_post_count($user_stats['UID']), "</td>\n";
            echo "                  <td>{$user_stats['POST_COUNT']}</td>\n";
            echo "                  <td>", round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), "%</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td colspan=\"4\">{$lang['nodata']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" align=\"center\">{$lang['totalpoststhismonth']}: {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <h2>{$lang['top10postersforthisweek']}</h2>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['totalposts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['posts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['percentofthisweeksposts']}</td>\n";
    echo "                </tr>\n";

    $user_stats_array = get_week_post_tallys();

    if (sizeof($user_stats_array['user_stats']) > 0) {

        foreach ($user_stats_array['user_stats'] as $user_stats) {

            echo "                <tr>\n";
            echo "                  <td>", format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']), "</td>\n";
            echo "                  <td>", user_get_post_count($user_stats['UID']), "</td>\n";
            echo "                  <td>{$user_stats['POST_COUNT']}</td>\n";
            echo "                  <td>", round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), "%</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td colspan=\"4\">{$lang['nodata']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" align=\"center\">{$lang['totalpoststhisweek']}: {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <h2>{$lang['top10postersfortoday']}</h2>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['totalposts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['posts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['percentoftodaysposts']}</td>\n";
    echo "                </tr>\n";

    $user_stats_array = get_day_post_tallys();

    if (sizeof($user_stats_array['user_stats']) > 0) {

        foreach ($user_stats_array['user_stats'] as $user_stats) {

            echo "                <tr>\n";
            echo "                  <td>", format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']), "</td>\n";
            echo "                  <td>", user_get_post_count($user_stats['UID']), "</td>\n";
            echo "                  <td>{$user_stats['POST_COUNT']}</td>\n";
            echo "                  <td>", round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), "%</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td colspan=\"4\">{$lang['nodata']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" align=\"center\">{$lang['totalpoststoday']}: {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <h2>Top 10 posters for this hour</h2>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">{$lang['user']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['totalposts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['posts']}</td>\n";
    echo "                  <td class=\"subhead\">{$lang['percentofthishoursposts']}</td>\n";
    echo "                </tr>\n";

    $user_stats_array = get_hour_post_tallys();

    if (sizeof($user_stats_array['user_stats']) > 0) {

        foreach ($user_stats_array['user_stats'] as $user_stats) {

            echo "                <tr>\n";
            echo "                  <td>", format_user_name($user_stats['LOGON'], $user_stats['NICKNAME']), "</td>\n";
            echo "                  <td>", user_get_post_count($user_stats['UID']), "</td>\n";
            echo "                  <td>{$user_stats['POST_COUNT']}</td>\n";
            echo "                  <td>", round((100 / $user_stats_array['post_count']) * $user_stats['POST_COUNT'], 2), "%</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td colspan=\"4\">{$lang['nodata']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" align=\"center\">{$lang['totalpoststhishour']}: {$user_stats_array['post_count']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

}else {

    html_draw_top("refresh=2:admin_post_stats.php?webtag=$webtag&amp;doreport=1");

    echo "  <h1>{$lang['admin']}: {$lang['postingstats']}</h1>\n";
    echo "  <h2>Please wait while report is generated...</h2>\n";
}

html_draw_bottom();

?>