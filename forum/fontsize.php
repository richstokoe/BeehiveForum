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

/* $Id: fontsize.php,v 1.10 2003-12-02 22:02:22 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// style.php : handles site styles with user preferences

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");
require_once("./include/session.inc.php");

bh_session_check();

header("Content-Type: text/css");

$fontsize = bh_session_get_value('FONT_SIZE');

if ($fontsize <> 10) {

    $fontsize = bh_session_get_value('FONT_SIZE');

    if ($fontsize < 5) $fontsize = 5;
    if ($fontsize > 15) $fontsize = 15;

    echo "BODY               { font-size: ", $fontsize, "pt }\n";
    echo ".navpage           { font-size: ", $fontsize * 0.8, "pt }\n";
    echo "P                  { font-size: ", $fontsize, "pt }\n";
    echo "H1                 { font-size: ", $fontsize, "pt }\n";
    echo "H2                 { font-size: ", $fontsize, "pt }\n";
    echo ".smalltext         { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".thread_list_mode  { font-size: ", $fontsize, "pt }\n";
    echo ".threads           { font-size: ", $fontsize, "pt }\n";
    echo ".folderinfo        { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".folderpostnew     { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".threadname        { font-size: ", $fontsize, "pt }\n";
    echo ".threadtime        { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".threadxnewofy     { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".foldername        { font-size: ", $fontsize, "pt }\n";
    echo ".posthead          { font-size: ", $fontsize, "pt }\n";
    echo ".postbody          { font-size: ", $fontsize, "pt }\n";
    echo ".postnumber        { font-size: ", $fontsize, "pt }\n";
    echo ".postinfo          { font-size: ", $fontsize, "pt }\n";
    echo ".posttofromlabel   { font-size: ", $fontsize, "pt }\n";
    echo ".posttofrom        { font-size: ", $fontsize, "pt }\n";
    echo ".postresponse      { font-size: ", $fontsize, "pt }\n";
    echo ".messagefoot       { font-size: ", $fontsize, "pt }\n";
    echo ".notifier          { font-size: ", $fontsize, "pt }\n";
    echo ".button            { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".smallbutton       { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".subhead           { font-size: ", $fontsize, "pt }\n";
    echo ".bhinputtext	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhtextarea	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhselect	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhinputcheckbox   { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".bhinputradio      { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".highlight         { font-size: ", $fontsize, "pt }\n";
    echo ".quotetext         { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".activeusers       { font-size: ", floor($fontsize * 0.8), "pt }\n";
}

?>