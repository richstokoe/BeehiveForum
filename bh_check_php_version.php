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

/* $Id$ */

// Requires PHP PEAR to be installed and PHP_CompatInfo Class.
// See: http://www.laurent-laville.org/index.php?module=pear&desc=pci

require_once 'PHP/CompatInfo.php';

// Set some options

$options = array('debug'            => false,
                 'recurse_dir'      => true,
                 'ignore_files'     => array('forum\include\compat.inc.php'),
                 'ignore_dirs'      => array('forum\include\db', 'forum\include\languages', 'forum\include\swift', 'forum\geshi', 'forum\tiny_mce'),
                 'ignore_functions' => array('mb_send_mail', 'mb_strlen', 'mb_strpos', 'mb_strrpos', 
                                             'mb_stripos', 'mb_substr', 'mb_strtolower', 'mb_strtoupper', 
                                             'mb_substr_count', 'mb_split', 'sys_get_temp_dir', 
                                             'file_put_contents', 'array_combine', 'date_default_timezone_set')); 

// Tell the user what we're doing.

echo "Please wait checking Minimum PHP Version...<br />\n<br />\n";

// Check the version

$pci = new PHP_CompatInfo('null');

$res = $pci->parseFolder('forum', $options);

// PHP_CompatInfo doesn't like date_default_timezone_set.
// It reports it as requiring PHP 5.2.0 when it works on
// PHP 5.1.0. Adding it to the ignore_fuctions list means
// the reported version number comes back as 5.0.0 which
// is incorrect, thus this next line.

if (version_compare($res['version'], "5.1.0", "<")) {
    $res['version'] = '5.1.0';
}

// Output the results.

printf("PHP Minimum Version = %s<br />\nExtensions required : %s<br />\n\n", $res['version'], implode(", ", $res['extensions']));

// Iterate over the result array. If the array value contains a subkey named 
// version it is a file that we can display information about.

foreach ($res as $script_filename => $version_info) {
    if (isset($version_info['version'])) {
        $versions_array[$version_info['version']][] = $script_filename;
    }
}

ksort($versions_array);

// Display the filenames grouped by version.

foreach ($versions_array as $version => $script_filenames) {
    if (sizeof($script_filename) > 0) {
        printf("%s<br />%s<br />%s<br /><br />\n", $version, str_repeat('=', strlen($version)), implode("<br />\n", $script_filenames));
    }
}

?>