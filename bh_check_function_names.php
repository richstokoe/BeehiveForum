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

/* $Id: bh_check_function_names.php,v 1.1 2009/07/11 19:16:48 decoyduck Exp $ */

// Callback function to escape array of strings.

function preg_quote_callback($str)
{
    return preg_quote($str, "/");
}

// Array to hold source files

$source_files_array = array();

// Path to source files.

$source_files_dir_array = array('forum\include');

// Ignore these files

$ignore_files_array = array('dictionary.inc.ph', 'text_captcha.inc.php');

echo "Getting list of functions...\n";

foreach ($source_files_dir_array as $include_file_dir) {

    if (($dir = opendir($include_file_dir))) {

        while (($file = readdir($dir)) !== false) {

            $path_info_array = pathinfo("$include_file_dir\\$file");
            
            if (isset($path_info_array['extension']) && $path_info_array['extension'] == 'php' && !in_array($path_info_array['basename'], $ignore_files_array)) {
            
                $function_prefix = str_replace('.inc.php', '', $file);
            
                $source_file_contents = file_get_contents("$include_file_dir\\$file");
                
                if (preg_match_all("/function ([a-z_-]+)\s?\(([^\)]*)\)/", $source_file_contents, $function_matches_array, PREG_SET_ORDER) > 0) {
                    
                    foreach ($function_matches_array as $function_match) {
                    
                        if (substr($function_match[1], 0, strlen($function_prefix)) != $function_prefix) {
                        
                            echo $file, ": ", $function_match[0], "\n";
                        }
                    }
                }            
            }
        }
    }
}

?>