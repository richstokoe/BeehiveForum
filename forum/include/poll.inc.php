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

/* $Id: poll.inc.php,v 1.65 2003-09-02 23:21:10 decoyduck Exp $ */

// Author: Matt Beale

require_once('./include/messages.inc.php');
require_once('./include/thread.inc.php');
require_once('./include/user_rel.inc.php');
require_once("./include/lang.inc.php");

function poll_create($tid, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type)
{

    $db_poll_create = db_connect();

    if ($closes) {
      $closes = "from_unixtime($closes)";
    }else {
      $closes = 'NULL';
    }

    $sql = "insert into ". forum_table("POLL"). " (TID, CLOSES, CHANGEVOTE, POLLTYPE, SHOWRESULTS, VOTETYPE) ";
    $sql.= "values ('$tid', $closes, '$change_vote', '$poll_type', '$show_results', '$poll_vote_type')";

    if (db_query($sql, $db_poll_create)) {

      for ($i = 0; $i <= sizeof($poll_options); $i++) {

        if (isset($poll_options[$i]) && trim($poll_options[$i]) != "") {

          $option_name  = addslashes($poll_options[$i]);
          $option_group = (isset($answer_groups[$i])) ? $answer_groups[$i] : 1;

          $sql = "insert into ". forum_table("POLL_VOTES"). " (TID, OPTION_NAME, GROUP_ID) ";
          $sql.= "values ('$tid', '$option_name', '$option_group')";

          $result = db_query($sql, $db_poll_create);

        }

      }

    }else {

      return false;

    }

}

function poll_edit($tid, $poll_question, $poll_options, $answer_groups, $closes, $change_vote, $poll_type, $show_results, $poll_vote_type)
{

    $db_poll_edit = db_connect();

    // Rename the thread

    $sql = "UPDATE ".forum_table("THREAD")." SET TITLE = '$poll_question' WHERE TID = $tid";
    $result = db_query($sql, $db_poll_edit);

    // Delete the recorded user votes for this poll

    $sql = "DELETE FROM ". forum_table("USER_POLL_VOTES"). " WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    // Update the Poll settings

    if ($closes) {
      $closes = "FROM_UNIXTIME($closes)";
    }else {
      $closes = 'NULL';
    }

    $sql = "UPDATE ". forum_table("POLL"). " SET CHANGEVOTE = '$change_vote', ";
    $sql.= "POLLTYPE = '$poll_type', SHOWRESULTS = '$show_results', VOTETYPE = '$poll_vote_type' ";

    if ($closes && $closes > 0) $sql.= ", CLOSES = $closes ";

    $sql.= "WHERE TID = '$tid'";

    $result = db_query($sql, $db_poll_edit);

    // Delete the available options for the poll

    $sql = "DELETE FROM ". forum_table("POLL_VOTES"). " WHERE TID = '$tid'";
    $result = db_query($sql, $db_poll_edit);

    // Insert the new poll options

    for ($i = 0; $i <= sizeof($poll_options); $i++) {

      if (isset($poll_options[$i]) && trim($poll_options[$i]) != "") {

        $option_name  = addslashes($poll_options[$i]);
        $option_group = (isset($answer_groups[$i])) ? $answer_groups[$i] : 1;

        $sql = "insert into ". forum_table("POLL_VOTES"). " (TID, OPTION_NAME, GROUP_ID) ";
        $sql.= "values ('$tid', '$option_name', '$option_group')";

        $result = db_query($sql, $db_poll_edit);

      }

    }
}

function poll_get($tid)
{
    $uid = bh_session_get_value('UID');

    $db_poll_get = db_connect();

    $sql = "select POST.PID, POST.REPLY_TO_PID, POST.FROM_UID, POST.TO_UID, ";
    $sql.= "UNIX_TIMESTAMP(POST.CREATED) as CREATED, POST.VIEWED, ";
    $sql.= "FUSER.LOGON as FLOGON, FUSER.NICKNAME as FNICK, ";
    $sql.= "TUSER.LOGON as TLOGON, TUSER.NICKNAME as TNICK, USER_PEER.RELATIONSHIP, ";
    $sql.= "POLL.CHANGEVOTE, POLL.POLLTYPE, POLL.SHOWRESULTS, POLL.VOTETYPE, ";
    $sql.= "UNIX_TIMESTAMP(POLL.CLOSES) as CLOSES ";
    $sql.= "from ". forum_table("POST"). " POST ";
    $sql.= "left join ". forum_table("USER"). " FUSER on (POST.FROM_UID = FUSER.UID) ";
    $sql.= "left join ". forum_table("USER"). " TUSER on (POST.TO_UID = TUSER.UID) ";
    $sql.= "left join ". forum_table("POLL"). " POLL on (POST.TID = POLL.TID) ";
    $sql.= "left join ". forum_table("USER_PEER") . " USER_PEER ";
    $sql.= "on (USER_PEER.UID = $uid and USER_PEER.PEER_UID = POST.FROM_UID) ";
    $sql.= "where POST.TID = $tid and POST.PID = 1";

    $result = db_query($sql, $db_poll_get);
    $polldata = db_fetch_array($result);

    if (!isset($polldata['TNICK'])) {
        $polldata['TNICK']  = "ALL";
        $polldata['TLOGON'] = "ALL";
    }

    if (!isset($polldata['CLOSES'])) {
        $polldata['CLOSES'] = 0;
    }

    return $polldata;

}

function poll_get_votes($tid)
{

    $db_poll_get_votes = db_connect();

    $sql = "SELECT OPTION_ID, OPTION_NAME, GROUP_ID, VOTES ";
    $sql.= "FROM ". forum_table('POLL_VOTES'). " WHERE TID = $tid ";

    $result = db_query($sql, $db_poll_get_votes);

    $option_ids    = array();
    $option_names  = array();
    $option_groups = array();
    $option_votes  = array();

    $pollresults = array();

    while($row = db_fetch_array($result)) {
        $option_ids[]    = $row['OPTION_ID'];
        $option_names[]  = $row['OPTION_NAME'];
        $option_groups[] = $row['GROUP_ID'];
        $option_votes[]  = $row['VOTES'];
    }

    $pollresults = array('OPTION_ID'   => $option_ids,
                         'OPTION_NAME' => $option_names,
                         'GROUP_ID'    => $option_groups,
                         'VOTES'       => $option_votes);

    return $pollresults;

}

function poll_get_user_votes($tid)
{
    $db_poll_get_user_vote_hashes = db_connect();

    $sql = "select PTUID, OPTION_ID from ". forum_table("USER_POLL_VOTES"). " where TID = $tid";
    $result = db_query($sql, $db_poll_get_user_vote_hashes);

    $poll_get_user_votes = array();

    while($row = db_fetch_array($result)) {
      $poll_get_user_votes[] = array('PTUID' => $row['PTUID'],
                                     'OPTION_ID' => $row['OPTION_ID']);
    }

    return $poll_get_user_votes;
}

function poll_get_user_vote($tid)
{
    $uid = bh_session_get_value('UID');

    $polldata = poll_get($tid);
    if ($polldata['CHANGEVOTE'] == 2) return POLL_MULTIVOTE;

    $db_poll_get_user_vote = db_connect();

    $sql = "select OPTION_ID, UNIX_TIMESTAMP(TSTAMP) AS TSTAMP from ". forum_table('USER_POLL_VOTES'). " ";
    $sql.= "where PTUID = MD5($tid.$uid) ORDER BY ID";

    $result = db_query($sql, $db_poll_get_user_vote);

    if (db_num_rows($result)) {
      $userpolldata = array();
      while($row = db_fetch_array($result)) {
        $userpolldata[] = $row;
      }
    }else {
      $userpolldata = false;
    }

    return $userpolldata;

}

function poll_sort_groups($a, $b) {

    if ($a['GROUP_ID'] == $b['GROUP_ID']) return 0;
    return ($a['GROUP_ID'] > $b['GROUP_ID']) ? 1 : -1;

}

function poll_display($tid, $msg_count, $first_msg, $in_list = true, $closed = false, $limit_text = true, $is_poll = true, $show_sigs = true, $is_preview = false, $highlight = array())
{

    global $HTTP_SERVER_VARS, $lang;
    $uid = bh_session_get_value('UID');

    $polldata     = poll_get($tid);
    $pollresults  = poll_get_votes($tid);
    $userpolldata = poll_get_user_vote($tid);

    $totalvotes   = 0;
    $optioncount  = 0;

    $polldata['CONTENT'] = "<br />\n";
    $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
    $polldata['CONTENT'].= "  <tr>\n";
    $polldata['CONTENT'].= "    <td>\n";

    $polldata['CONTENT'].= "      <form method=\"post\" action=\"". $HTTP_SERVER_VARS['PHP_SELF']. "\" target=\"_self\">\n      ";
    $polldata['CONTENT'].= form_input_hidden('tid', $tid). "\n";
    $polldata['CONTENT'].= "      <table width=\"450\" align=\"center\">\n";
    $polldata['CONTENT'].= "        <tr>\n";
    $polldata['CONTENT'].= "          <td colspan=\"2\"><h2>". thread_get_title($tid). "</h2></td>\n";
    $polldata['CONTENT'].= "        </tr>\n";

    $poll_group_count = 1;

    if ($in_list) {

      if ((!is_array($userpolldata) && bh_session_get_value('UID') > 0) && ($polldata['CLOSES'] == 0 || $polldata['CLOSES'] > gmmktime())) {

        array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

        for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

          if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

          if (strlen($pollresults['OPTION_NAME'][$i]) > 0) {

            if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldata['CONTENT'].= "                <td colspan=\"2\"><hr /></td>\n";
                $poll_group_count++;
            }

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td class=\"postbody\" valign=\"top\" width=\"15\">". form_radio("pollvote[{$pollresults['GROUP_ID'][$i]}]", $pollresults['OPTION_ID'][$i], '', false). "</td>\n";
            $polldata['CONTENT'].= "          <td class=\"postbody\" width=\"435\">". $pollresults['OPTION_NAME'][$i]. "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

            $poll_previous_group = $pollresults['GROUP_ID'][$i];

          }

        }

      }else {

        if ($polldata['SHOWRESULTS'] == 1) {

          if ($polldata['POLLTYPE'] == 0) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_horizontal_graph($tid);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }elseif ($polldata['POLLTYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_vertical_graph($tid);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }else {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\">\n";
            $polldata['CONTENT'].= poll_public_ballot($tid);
            $polldata['CONTENT'].= "          </td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }else {

          for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

            if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

            if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

              if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
                $polldata['CONTENT'].= "                <td colspan=\"2\"><hr /></td>\n";
                $poll_group_count++;
              }

              $polldata['CONTENT'].= "        <tr>\n";
              $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">". $pollresults['OPTION_NAME'][$i]. "</td>\n";
              $polldata['CONTENT'].= "        </tr>\n";

              $poll_previous_group = $pollresults['GROUP_ID'][$i];

            }

          }

        }

      }

    }else {

      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">\n";
      $polldata['CONTENT'].= "            <ul>\n";

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        if (strlen($pollresults['OPTION_NAME'][$i]) > 0) {

          $polldata['CONTENT'].= "        <li>". $pollresults['OPTION_NAME'][$i]. "</li>\n";

        }

      }

      $polldata['CONTENT'].= "            </ul>\n";
      $polldata['CONTENT'].= "          </td>\n";
      $polldata['CONTENT'].= "        </tr>\n";

    }

    if ($in_list) {

      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

      $group_array = array();

      for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

        $totalvotes = $totalvotes + $pollresults['VOTES'][$i];

        if (!in_array($pollresults['GROUP_ID'][$i], $group_array)) {
            $group_array[] = $pollresults['GROUP_ID'][$i];
        }
      }

      $poll_group_count = sizeof($group_array);
      $totalvotes = ceil($totalvotes / $poll_group_count);

      if ($totalvotes == 0 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyvoted']}</b>";

      }elseif ($totalvotes == 0 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['nobodyhasvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personvoted']}</b>";

      }elseif ($totalvotes == 1 && ($polldata['CLOSES'] > gmmktime() || $polldata['CLOSES'] == 0)) {

        $polldata['CONTENT'].= "<b>{$lang['1personhasvoted']}</b>";

      }else {

        if ($polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) {

          $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplevoted']}</b>";

        }else {

          $polldata['CONTENT'].= "<b>$totalvotes {$lang['peoplehavevoted']}</b>";

        }

      }

      $polldata['CONTENT'].= "</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";
      $polldata['CONTENT'].= "        <tr>\n";
      $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
      $polldata['CONTENT'].= "        </tr>\n";

      if (($polldata['CLOSES'] <= gmmktime()) && $polldata['CLOSES'] != 0) {

        $polldata['CONTENT'].= "        <tr>\n";
        $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">{$lang['pollhasended']}.</td>\n";
        $polldata['CONTENT'].= "        </tr>\n";

        if (is_array($userpolldata)) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].=  " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

        }

      }else {

        if (is_array($userpolldata)) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" class=\"postbody\">";

          $userpollvotes_array = array();

          for ($i = 0; $i < sizeof($userpolldata); $i++) {
            for ($j = 0; $j < sizeof($pollresults['OPTION_ID']); $j++) {
              if ($userpolldata[$i]['OPTION_ID'] == $pollresults['OPTION_ID'][$j]) {
                if ($pollresults['OPTION_NAME'][$j] == strip_tags($pollresults['OPTION_NAME'][$j])) {
                  $userpollvotes_array[] = "'{$pollresults['OPTION_NAME'][$j]}'";
                }else {
                  $userpollvotes_array[] = "Option {$userpolldata[$i]['OPTION_ID']}";
                }
              }
            }
          }

          $polldata['CONTENT'].= "{$lang['youvotedfor']}: ". implode(" & ", $userpollvotes_array);
          $polldata['CONTENT'].=  " {$lang['on']} ". gmdate("jS M Y", $userpolldata[0]['TSTAMP']). ".</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\">&nbsp;</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">";

          if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

            if ($polldata['VOTETYPE'] == 1) {

              $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }else {

              $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }
          }

          if(bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']). "</td>\n";

          }

          $polldata['CONTENT'].= "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

          if ($polldata['CHANGEVOTE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">". form_submit('pollchangevote', $lang['changevote']). "</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

          if ($polldata['VOTETYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }elseif (bh_session_get_value('UID') > 0) {

          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">". form_submit('pollsubmit', $lang['vote']). "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";
          $polldata['CONTENT'].= "        <tr>\n";
          $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">";

          if (($polldata['SHOWRESULTS'] == 1 && $totalvotes > 0) || bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

            if ($polldata['VOTETYPE'] == 1) {

              $polldata['CONTENT'].= form_button("pollresults", $lang['resultdetails'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }else {

              $polldata['CONTENT'].= form_button("pollresults", $lang['results'], "onclick=\"window.open('pollresults.php?tid=". $tid. "', 'pollresults', 'width=520, height=360, toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=yes, resizable=yes');\"");

            }

          }

          if (bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()){

            $polldata['CONTENT'].= "&nbsp;". form_submit('pollclose', $lang['endpoll']);

          }

          $polldata['CONTENT'].= "</td>\n";
          $polldata['CONTENT'].= "        </tr>\n";

          if ($polldata['VOTETYPE'] == 1) {

            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\">&nbsp;</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";
            $polldata['CONTENT'].= "        <tr>\n";
            $polldata['CONTENT'].= "          <td colspan=\"2\" align=\"center\" class=\"postbody\">{$lang['polltypewarning']}</td>\n";
            $polldata['CONTENT'].= "        </tr>\n";

          }

        }

      }

    }

    $polldata['CONTENT'].= "      </table>\n";
    $polldata['CONTENT'].= "      </form>\n";
    $polldata['CONTENT'].= "    </td>\n";
    $polldata['CONTENT'].= "  </tr>\n";
    $polldata['CONTENT'].= "</table>\n";
    $polldata['CONTENT'].= "<p>&nbsp;</p>\n";

    // Work out what relationship the user has to the user who posted the poll
    $polldata['FROM_RELATIONSHIP'] = user_rel_get(bh_session_get_value('UID'), $polldata['FROM_UID']);

    message_display($tid, $polldata, $msg_count, $first_msg, true, $closed, $limit_text, true, $show_sigs, $is_preview, $highlight);

}

function poll_preview_graph_horz($pollresults)
{
    global $lang;

    $totalvotes  = 0;
    $max_value   = 0;
    $optioncount = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {
      if ($pollresults['VOTES'][$i] > $max_value) $max_value = $pollresults['VOTES'][$i];
      $totalvotes = $totalvotes + $pollresults['VOTES'][$i];
      $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    if ($max_value > 0) {
      $bar_width = round(300 / $max_value, 2);
    }else {
      $bar_width = 0;
    }

    $polldisplay = "            <table width=\"100%\" align=\"center\">\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
            $polldisplay.= "                <td colspan=\"2\"><hr /></td>\n";
            $poll_group_count++;
        }

        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">". $pollresults['OPTION_NAME'][$i]. "</td>\n";

        if ($pollresults['VOTES'][$i] > 0) {

          $polldisplay.= "                <td width=\"300\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor($bar_width * $pollresults['VOTES'][$i]). "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";

        }

        $totalsvotes = $totalvotes / $poll_group_count;

        if ($totalvotes > 0) {
            $vote_percent = round((100 / $totalvotes) * $pollresults['VOTES'][$i], 2);
        }else {
            $vote_percent = 0;
        }

        $polldisplay.= "              </tr>\n";
        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
        $polldisplay.= "                <td class=\"postbody\" height=\"20\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
        $polldisplay.= "              </tr>\n";

        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "            </table>\n";

    return $polldisplay;
}

function poll_preview_graph_vert($pollresults)
{
    global $lang;

    $totalvotes  = 0;
    $max_value   = 0;
    $optioncount = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {
      if ($pollresults['VOTES'][$i] > $max_value) $max_value = $pollresults['VOTES'][$i];
      $totalvotes = $totalvotes + $pollresults['VOTES'][$i];
      $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    if ($max_value > 0) {

      $bar_height  = round(200 / $max_value, 2);
      $bar_width   = round(400 / $optioncount, 2);

    }else {

      $bar_height  = 0;
      $bar_width   = round(400 / $optioncount, 2);

    }

    $polldisplay = "            <table width=\"460\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "              <tr>\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['VOTES'][$i] > 0) {

          if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
              $polldisplay.= "                <td style=\"border-left: 1px solid #000000\">&nbsp;</td>\n";
              $poll_group_count++;
          }

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". $bar_height * $pollresults['VOTES'][$i]. "px; width: ". $bar_width. "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". $bar_width. "px\">&nbsp;</td>\n";

        }

        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "              <tr>\n";

    $totalsvotes = $totalvotes / $poll_group_count;

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($totalvotes > 0) {
            $vote_percent = round((100 / $totalvotes) * $pollresults['VOTES'][$i], 2);
        }else {
            $vote_percent = 0;
        }

        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
            $polldisplay.= "                <td style=\"border-left: 1px solid #000000\">&nbsp;</td>\n";
            $poll_group_count++;
        }

        $polldisplay.= "                <td class=\"postbody\" align=\"center\" valign=\"top\">". $pollresults['OPTION_NAME'][$i]. "<br />". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";

        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "            </table>\n";

    return $polldisplay;
}

function poll_horizontal_graph($tid)
{
    global $lang;

    $totalvotes  = array();
    $max_values  = array();

    $bar_color = 1;
    $poll_group_count = 1;

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
        $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $max_values[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }

      if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
        $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $totalvotes[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "            <table width=\"100%\" align=\"center\">\n";

    for ($i = 0; $i <= sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
            $polldisplay.= "                <td colspan=\"2\"><hr /></td>\n";
            $poll_group_count++;
        }

        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">". $pollresults['OPTION_NAME'][$i]. "</td>\n";

        if ($pollresults['VOTES'][$i] > 0) {

          $polldisplay.= "                <td width=\"300\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: 25px; width: ". floor(round(300 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td class=\"postbody\" height=\"25\">&nbsp;</td>\n";

        }

        if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
            $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
        }else {
            $vote_percent = 0;
        }

        $polldisplay.= "              </tr>\n";
        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"postbody\">&nbsp;</td>\n";
        $polldisplay.= "                <td class=\"postbody\" height=\"20\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
        $polldisplay.= "              </tr>\n";

        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "            </table>\n";

    return $polldisplay;

}

function poll_vertical_graph($tid)
{
    global $lang;

    $totalvotes  = array();
    $max_values  = array();

    $optioncount = 0;

    $bar_color = 1;
    $poll_group_count = 1;

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
        $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $max_values[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }

      if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
        $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $totalvotes[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }

      $optioncount++;
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $polldisplay = "            <table width=\"460\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n";
    $polldisplay.= "              <tr>\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['VOTES'][$i] > 0) {

          if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
              $polldisplay.= "                <td style=\"border-left: 1px solid #000000\">&nbsp;</td>\n";
              $poll_group_count++;
          }

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\">\n";
          $polldisplay.= "                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"height: ". floor(round(200 / $max_values[$pollresults['GROUP_ID'][$i]], 2) * $pollresults['VOTES'][$i]). "px; width: ". round(400 / $optioncount, 2). "px\">\n";
          $polldisplay.= "                    <tr>\n";
          $polldisplay.= "                      <td class=\"pollbar". $bar_color. "\">&nbsp;</td>\n";
          $polldisplay.= "                    </tr>\n";
          $polldisplay.= "                  </table>\n";
          $polldisplay.= "                </td>\n";

        }else {

          $polldisplay.= "                <td align=\"center\" valign=\"bottom\" class=\"postbody\" style=\"width: ". round(400 / $optioncount, 2). "px\">&nbsp;</td>\n";

        }

        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

      $bar_color++;
      if ($bar_color > 5) $bar_color = 1;

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "              <tr>\n";

    unset($poll_previous_group);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
            $polldisplay.= "                <td style=\"border-left: 1px solid #000000\">&nbsp;</td>\n";
            $poll_group_count++;
        }

        if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
            $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
        }else {
            $vote_percent = 0;
        }

        $polldisplay.= "                <td class=\"postbody\" align=\"center\" valign=\"top\">". $pollresults['OPTION_NAME'][$i]. "<br />". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
        $poll_previous_group = $pollresults['GROUP_ID'][$i];

      }

    }

    $polldisplay.= "              </tr>\n";
    $polldisplay.= "            </table>\n";

    return $polldisplay;

}

function poll_public_ballot($tid, $bar_width, $totalvotes)
{
    global $lang;

    $totalvotes  = array();
    $max_value   = array();

    $bgcolor = 0;

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($max_values[$pollresults['GROUP_ID'][$i]])) {
        $max_values[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $max_values[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }

      if (!isset($totalvotes[$pollresults['GROUP_ID'][$i]])) {
        $totalvotes[$pollresults['GROUP_ID'][$i]] = $pollresults['VOTES'][$i];
      }else {
        $totalvotes[$pollresults['GROUP_ID'][$i]]+= $pollresults['VOTES'][$i];
      }
    }

    array_multisort($pollresults['GROUP_ID'], SORT_NUMERIC, SORT_ASC, $pollresults['OPTION_ID'], $pollresults['OPTION_NAME'], $pollresults['VOTES']);

    $user_votes = poll_get_user_votes($tid);
    $user_count = user_count();

    $polldisplay = "            <table width=\"460\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" class=\"box\">\n";
    $polldisplay.= "              <tr>\n";

    for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

      if (!isset($poll_previous_group)) $poll_previous_group = $pollresults['GROUP_ID'][$i];

      if (isset($pollresults['OPTION_NAME'][$i]) && strlen($pollresults['OPTION_NAME'][$i]) > 0) {

        if ($pollresults['GROUP_ID'][$i] <> $poll_previous_group) {
          $polldisplay.= "            </table><br />\n";
          $polldisplay.= "            <table width=\"460\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" class=\"box\">\n";
        }

        $polldisplay.= "              <tr>\n";
        $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\" style=\"border-bottom: 1px solid\"><h2>". $pollresults['OPTION_NAME'][$i]. "</h2></td>\n";

        if ($pollresults['VOTES'][$i] > 0) {

          if (isset($totalvotes[$pollresults['GROUP_ID'][$i]]) && $totalvotes[$pollresults['GROUP_ID'][$i]] > 0) {
              $vote_percent = round((100 / $totalvotes[$pollresults['GROUP_ID'][$i]]) * $pollresults['VOTES'][$i], 2);
          }else {
              $vote_percent = 0;
          }

          $polldisplay.= "                <td  class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\" style=\"border-bottom: 1px solid\">". $pollresults['VOTES'][$i]. " {$lang['votes']} (". $vote_percent. "%)</td>\n";
          $polldisplay.= "              </tr>\n";

          for($j = 0; $j < sizeof($user_votes); $j++) {

            for ($k = 1; $k <= $user_count; $k++) {

              if ((md5("$tid.$k") == $user_votes[$j]['PTUID']) && ($user_votes[$j]['OPTION_ID'] == $pollresults['OPTION_ID'][$i])) {

                $user = user_get($k);

                $polldisplay.= "              <tr>\n";
                $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\">&nbsp;</td>\n";
                $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\"><a href=\"javascript:void(0);\" onclick=\"openProfile({$k})\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']). "</a></td>\n";
                $polldisplay.= "              </tr>\n";

              }
            }
          }

          $polldisplay.= "              <tr>\n";
          $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\">&nbsp;</td>\n";
          $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\">&nbsp;</td>\n";
          $polldisplay.= "              </tr>\n";

        }else {

          $polldisplay.= "                <td  class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\" style=\"border-bottom: 1px solid\">0 {$lang['votes']} (0%)</td>\n";
          $polldisplay.= "              </tr>\n";
          $polldisplay.= "              <tr>\n";
          $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\">&nbsp;</td>\n";
          $polldisplay.= "                <td width=\"150\" class=\"". (($bgcolor == 0) ? "highlight" : "postbody"). "\">&nbsp;</td>\n";
          $polldisplay.= "              </tr>\n";

        }
      }

      $poll_previous_group = $pollresults['GROUP_ID'][$i];
    }

    $polldisplay.= "            </table><br />\n";

    return $polldisplay;
}

function poll_confirm_close($tid)
{
    global $HTTP_SERVER_VARS, $lang;

    $preview_message = messages_get($tid, 1, 1);

    if(bh_session_get_value('UID') != $preview_message['FROM_UID'] && !perm_is_moderator()) {
        edit_refuse();
        return;
    }

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

    echo "<h2>{$lang['pollconfirmclose']}</h2>\n";

    poll_display($tid, $preview_message, 0, 0, false);

    echo "<p><form name=\"f_delete\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\" target=\"_self\">";
    echo form_input_hidden("tid", $tid);
    echo form_input_hidden("confirm_pollclose", "Y");
    echo form_submit("pollclose", $lang['endpoll']);
    echo "&nbsp;".form_submit("cancel", $lang['cancel']);
    echo "</form>\n";

}

function poll_close($tid)
{

    $db_poll_close = db_connect();

    $sql = "select FROM_UID from ". forum_table("POST"). " where TID = $tid and PID = 1";
    $result = db_query($sql, $db_poll_close);

    if (db_num_rows($result) > 0) {

      $polldata = db_fetch_array($result);

      if(bh_session_get_value('UID') == $polldata['FROM_UID'] || perm_is_moderator()) {

        $sql = "update ". forum_table("POLL"). " set CLOSES = FROM_UNIXTIME(". gmmktime(). ") where TID = $tid";
        $result = db_query($sql, $db_poll_close);

      }

    }

}

function poll_is_closed($tid)
{

    $db_poll_is_closed = db_connect();

    $sql = "select CLOSES from ". forum_table("POLL"). " where TID = $tid";
    $result = db_query($sql, $db_poll_is_closed);

    if (db_num_rows($result)) {
      $polldata = db_fetch_array($result);
      if (isset($polldata['CLOSES']) && $polldata['CLOSES'] <= gmmktime() && $polldata['CLOSES'] != 0) return true;
    }

    return false;

}

function poll_vote($tid, $vote_array)
{
    $uid = bh_session_get_value('UID');

    $db_poll_vote = db_connect();

    $polldata = poll_get($tid);
    $vote_count = sizeof($vote_array);

    if ($polldata['CHANGEVOTE'] == 2 || $uid == 0) {

      foreach ($vote_array as $user_vote) {

        $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES + 1 ";
        $sql.= "where TID = $tid and OPTION_ID = $vote";

        $result = db_query($sql, $db_poll_vote);
      }

    }elseif (!poll_get_user_vote($tid)) {

      foreach ($vote_array as $user_vote) {

        $sql = "insert into ". forum_table("USER_POLL_VOTES"). " (TID, PTUID, OPTION_ID, TSTAMP) ";
        $sql.= "values ($tid, MD5($tid.$uid), $user_vote, FROM_UNIXTIME(". mktime(). "))";

        $result = db_query($sql, $db_poll_vote);

        $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES + 1 ";
        $sql.= "where TID = $tid and OPTION_ID = $user_vote";

        $result = db_query($sql, $db_poll_vote);
      }
    }
}

function poll_delete_vote($tid)
{

    $db_poll_delete_vote = db_connect();

    $uid = bh_session_get_value('UID');

    $sql = "select OPTION_ID from ". forum_table("USER_POLL_VOTES"). " where PTUID = MD5($tid.$uid)";
    $result = db_query($sql, $db_poll_delete_vote);

    if (db_num_rows($result) > 0) {

      while($userpollvote = db_fetch_array($result)) {

        $sql = "update ". forum_table("POLL_VOTES"). " set VOTES = VOTES - 1 where OPTION_ID = ". $userpollvote['OPTION_ID']. " and TID = $tid";
        db_query($sql, $db_poll_delete_vote);
      }

      $sql = "delete from ". forum_table("USER_POLL_VOTES"). " where PTUID = MD5($tid.$uid)";
      $result = db_query($sql, $db_poll_delete_vote);

    }

}

function thread_is_poll($tid)
{

    $db_thread_is_poll = db_connect();

    $sql = "select CLOSES from ". forum_table("POLL"). " where TID = $tid";
    $result = db_query($sql, $db_thread_is_poll);

    if (db_num_rows($result) > 0) {

      return true;

    }else {

      return false;

    }

}

?>