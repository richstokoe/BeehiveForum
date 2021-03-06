<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'ip.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Redirect to Add Group page if requested.
if (isset($_POST['addnew'])) {
    header_redirect("admin_user_groups_add.php?webtag=$webtag");
}

// Column sorting stuff
if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "GROUP_NAME") {
        $sort_by = "GROUPS.GROUP_NAME";
    } else if ($_GET['sort_by'] == "GROUP_DESC") {
        $sort_by = "GROUPS.GROUP_DESC";
    } else if ($_GET['sort_by'] == "USER_COUNT") {
        $sort_by = "USER_COUNT";
    } else if ($_GET['sort_by'] == "GROUP_PERMS") {
        $sort_by = "GROUP_PERMS";
    } else {
        $sort_by = "GROUPS.GROUP_NAME";
    }
} else {
    $sort_by = "GROUPS.GROUP_NAME";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "ASC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else {
    $page = 1;
}

if (isset($_POST['delete'])) {

    $valid = true;

    if (isset($_POST['delete_group']) && is_array($_POST['delete_group'])) {

        foreach ($_POST['delete_group'] as $gid) {

            if (($group_name = perm_get_group_name($gid))) {

                if (perm_remove_group($gid)) {

                    admin_add_log_entry(DELETE_USER_GROUP, array($group_name));

                } else {

                    $error_msg_array[] = sprintf(gettext("Failed to delete group %s"), $group_name);
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("admin_user_groups.php?webtag=$webtag&deleted=true");
            exit;
        }
    }
}

html_draw_top(sprintf('title=%s', gettext("Admin - User Groups")), 'class=window_title');

$user_groups_array = perm_get_user_groups($page, $sort_by, $sort_dir);

echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("User Groups"), "</h1>\n";

if (isset($_GET['added'])) {

    html_display_success_msg(gettext("Successfully added group"), '86%', 'center');

} else if (isset($_GET['edited'])) {

    html_display_success_msg(gettext("Successfully edited group"), '86%', 'center');

} else if (isset($_GET['deleted'])) {

    html_display_success_msg(gettext("Successfully deleted selected groups"), '86%', 'center');

} else if (sizeof($user_groups_array['user_groups_array']) < 1) {

    html_display_warning_msg(gettext("No User Groups have been set up. To add a group click the 'Add New' button below."), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_folders\" action=\"admin_user_groups.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";

if ($sort_by == 'GROUPS.GROUP_NAME' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=DESC&amp;page=$page\">", gettext("Groups"), "</a></td>\n";
} else if ($sort_by == 'GROUPS.GROUP_NAME' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=ASC&amp;page=$page\">", gettext("Groups"), "</a></td>\n";
} else if ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=ASC&amp;page=$page\">", gettext("Groups"), "</a></td>\n";
} else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_NAME&amp;sort_dir=DESC&amp;page=$page\">", gettext("Groups"), "</a></td>\n";
}

if ($sort_by == 'GROUPS.GROUP_DESC' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=DESC&amp;page=$page\">", gettext("Description"), "</a></td>\n";
} else if ($sort_by == 'GROUPS.GROUP_DESC' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=ASC&amp;page=$page\">", gettext("Description"), "</a></td>\n";
} else if ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=ASC&amp;page=$page\">", gettext("Description"), "</a></td>\n";
} else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_DESC&amp;sort_dir=DESC&amp;page=$page\">", gettext("Description"), "</a></td>\n";
}

if ($sort_by == 'GROUP_PERMS' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=DESC&amp;page=$page\">", gettext("Group Status"), "</a></td>\n";
} else if ($sort_by == 'GROUP_PERMS' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"center\" class=\"header_sort_desc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=ASC&amp;page=$page\">", gettext("Group Status"), "</a></td>\n";
} else if ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=ASC&amp;page=$page\">", gettext("Group Status"), "</a></td>\n";
} else {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=GROUP_PERMS&amp;sort_dir=DESC&amp;page=$page\">", gettext("Group Status"), "</a></td>\n";
}

if ($sort_by == 'USER_COUNT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">", gettext("Users"), "</a></td>\n";
} else if ($sort_by == 'USER_COUNT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"center\" class=\"header_sort_desc\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">", gettext("Users"), "</a></td>\n";
} else if ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=ASC&amp;page=$page\">", gettext("Users"), "</a></td>\n";
} else {
    echo "                   <td class=\"subhead\" align=\"center\"><a href=\"admin_user_groups.php?webtag=$webtag&amp;sort_by=USER_COUNT&amp;sort_dir=DESC&amp;page=$page\">", gettext("Users"), "</a></td>\n";
}

echo "                </tr>\n";

if (sizeof($user_groups_array['user_groups_array']) > 0) {

    foreach ($user_groups_array['user_groups_array'] as $user_group) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", form_checkbox("delete_group[]", $user_group['GID']), "</td>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\"><a href=\"admin_user_groups_edit.php?webtag=$webtag&amp;gid={$user_group['GID']}\" target=\"_self\">{$user_group['GROUP_NAME']}</a></td>\n";

        if (isset($user_group['GROUP_DESC']) && strlen(trim($user_group['GROUP_DESC'])) > 0) {

            $group_desc_short = (mb_strlen(trim($user_group['GROUP_DESC'])) > 50) ? mb_substr($user_group['GROUP_DESC'], 0, 47). "&hellip;" : $user_group['GROUP_DESC'];

            echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\"><div title=\"", word_filter_add_ob_tags($user_group['GROUP_DESC'], true), "\">", word_filter_add_ob_tags($group_desc_short), "</div></td>\n";

        } else {

            echo "                  <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
        }

        if (isset($user_group['GROUP_PERMS']) && $user_group['GROUP_PERMS'] > 0) {
            echo "                  <td align=\"center\" valign=\"top\" width=\"15%\">", perm_display_list($user_group['GROUP_PERMS']), "</td>\n";
        } else {
            echo "                  <td align=\"center\" valign=\"top\" width=\"15%\">", gettext("none"), "</td>\n";
        }

        echo "                  <td align=\"center\" width=\"10%\" valign=\"top\"><a href=\"admin_user_groups_edit_users.php?webtag=$webtag&amp;gid={$user_group['GID']}\">{$user_group['USER_COUNT']}</a></td>\n";
        echo "                </tr>\n";
    }
}

echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" align=\"center\">", html_page_links("admin_user_groups.php?webtag=$webtag&sort_dir=$sort_dir&sort_by=$sort_by", $page, $user_groups_array['user_groups_count'], 10), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("addnew", gettext("Add New")), "&nbsp;", form_submit("delete", gettext("Delete Selected")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<br />\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" class=\"posthead\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td colspan=\"4\" class=\"subhead\" align=\"left\" style=\"white-space: nowrap\">Permissions Key</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table width=\"95%\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>AT</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Group can access admin tools"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>LM</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Group can moderate Links sections"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>UW</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Group is wormed"), "</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                      <td align=\"left\" valign=\"top\" width=\"50%\">\n";
echo "                        <table width=\"100%\">\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>FM</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Group can moderate all folders"), "</td>\n";
echo "                          </tr>\n";
echo "                          <tr>\n";
echo "                            <td align=\"left\" class=\"postbody\"><b>UB</b></td>\n";
echo "                            <td align=\"left\" class=\"postbody\">", gettext("Group is banned"), "</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" colspan=\"8\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>