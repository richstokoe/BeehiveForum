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

/* $Id: form.inc.php,v 1.99 2007-05-31 22:29:20 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

// Create a form field

function form_field($name, $value = false, $width = false, $maxchars = false, $type = "text", $custom_html = false, $class = "bhinputtext")
{
    $lang = load_language_file();

    $id = form_unique_id();

    $html = "<input type=\"$type\" name=\"$name\" id=\"$id\" class=\"$class\" value=\"$value\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    if ($width) {
        $width = (int)trim($width);
        $html.= "size=\"$width\" ";
    }

    if ($maxchars) {
        $maxchars = (int)trim($maxchars);
        $html.= "maxlength=\"$maxchars\" ";
    }

    $html.= "dir=\"{$lang['_textdir']}\" />";
    return $html;
}

// Generate unique form id

function form_unique_id()
{
    return preg_replace("/[^a-z]/", "", md5(uniqid(rand())));
}

// Creates a text input field

function form_input_text($name, $value = false, $width = false, $maxchars = false, $custom_html = false, $class = "bhinputtext")
{
    return form_field($name, $value, $width, $maxchars, "text", $custom_html, $class);
}

// Creates a password input field

function form_input_password($name, $value = false, $width = false, $maxchars = false, $custom_html = false, $class = "bhinputtext")
{
    return form_field($name, $value, $width, $maxchars, "password", $custom_html, $class);
}

// Creates a file upload field

function form_input_file($name, $value = false, $width = false, $maxchars = false, $custom_html = false, $class = "bhinputtext")
{
    return form_field($name, $value, $width, $maxchars, "file", $custom_html, $class);
}

// Creates a hidden form field

function form_input_hidden($name, $value = false, $custom_html = false)
{
    return form_field($name, $value, 0, 0, "hidden", $custom_html);
}


function form_input_hidden_array($array, $ignore_keys = array())
{
    if (!is_array($array)) return false;
    if (!is_array($ignore_keys)) return false;

    $array_keys = array();
    $array_values = array();

    flatten_array($array, $array_keys, $array_values);

    $result_var = "";

    foreach ($array_keys as $key => $key_name) {
        
        if (($key_name != 'webtag') && isset($array_values[$key])) {
        
            $result_var.= form_input_hidden($key_name, _htmlentities($array_values[$key])). "\n";
        }
    }

    return $result_var;
}

// Create a textarea input field

function form_textarea($name, $value, $rows, $cols, $wrap = "virtual", $custom_html = false, $class = "bhtextarea")
{
    $lang = load_language_file();

    $id = form_unique_id();

    $html = "<textarea name=\"$name\" id=\"$id\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    if ($rows) {
        $rows = (int)trim($rows);
        $html.= "rows=\"$rows\" ";
    }

    if ($cols) {
        $cols = (int)trim($cols);
        $html.= "cols=\"$cols\" ";
    }

    $html.= "dir=\"{$lang['_textdir']}\">$value</textarea>";
    return $html;
}

// Creates a dropdown with values from array(s)

function form_dropdown_array($name, $options_array, $default = false, $custom_html = false, $class = "bhselect", $group_class = "bhselectoptgroup")
{
    $lang = load_language_file();

    $id = form_unique_id();

    $html = "<select name=\"$name\" id=\"$id\" class=\"$class\" ";

    if ($custom_html) {

        $custom_html = trim($custom_html);
        $html.= " $custom_html";
    }

    $html.= ">";

    if (is_array($options_array)) {
        
        foreach ($options_array as $option_key => $option_text) {

            if (is_array($option_text)) {

                $html.= form_dropdown_objgroup_array($option_key, $option_text, $default, $custom_html, $group_class);
            
            }else {

                $selected = (strtolower($option_key) == strtolower($default)) ? " selected=\"selected\"" : "";
                $html.= "<option value=\"{$option_key}\"$selected>$option_text</option>";
            }
        }
    }

    $html.= "</select>";
    return $html;
}

// Creates a optgroup to be used in a dropdown.

function form_dropdown_objgroup_array($name, $options_array, $default = false, $custom_html = false, $class = "bhselectoptgroup")
{
    if (is_array($options_array)) {

        $html = "<optgroup label=\"$name\" class=\"$class\">";

        foreach ($options_array as $option_key => $option_text) {

            if (is_array($option_text)) {

                $html.= form_dropdown_objgroup_array($option_key, $option_text, $default, $custom_html, $class);

            }else {

                $selected = (strtolower($option_key) == strtolower($default)) ? " selected=\"selected\"" : "";
                $html.= "<option value=\"$option_key\"$selected>$option_text</option>";
            }
        }

        $html.= "</optgroup>";
        return $html;
    }
}    

// Creates a checkbox field

function form_checkbox($name, $value, $text, $checked = false, $custom_html = false, $class = "bhinputcheckbox")
{
    $id = form_unique_id();

    $html = "<span class=\"$class\">";
    $html.= "<input type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) $html.= " checked=\"checked\"";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= " $custom_html ";
    }

    $html.= "/>";

    if (is_array($text) && sizeof($text) > 0) {

        $html.= "<label for=\"$id\">";

        foreach($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html.= $text_part;

            }else {

                $html.= "</label>$text_part<label for=\"$id\">";
            }
        }

        $html.= "</label>";

    }elseif (strlen(trim($text)) > 0) {

        $html.= "<label for=\"$id\">$text</label>";
    }

    $html.= "</span>";

    return $html;
}

// Create a radio field

function form_radio($name, $value, $text, $checked = false, $custom_html = false, $class = "bhinputradio")
{
    $id = form_unique_id();

    $html = "<span class=\"$class\">";
    $html.= "<input type=\"radio\" name=\"$name\" id=\"$id\" value=\"$value\"";

    if ($checked) $html.= " checked=\"checked\"";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= " $custom_html ";
    }

    $html.= "/>";

    if (is_array($text) && sizeof($text) > 0) {

        $html.= "<label for=\"$id\">";

        foreach($text as $text_part) {

            if (!strstr($text_part, "<")) {

                $html.= $text_part;

            }else {

                $html.= "</label>$text_part<label for=\"$id\">";
            }
        }

        $html.= "</label>";

    }elseif (strlen(trim($text)) > 0) {

        $html.= "<label for=\"$id\">$text</label>";
    }

    $html.= "</span>";

    return $html;
}

// Create an array of radio fields.

function form_radio_array($name, $value, $text, $checked = false, $custom_html = false)
{
    for ($i = 0; $i < count($value); $i++) {
        if (isset($html)) {
            $html.= form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]), $custom_html);
        }else {
            $html = form_radio($name, $value[$i], $text[$i], ($checked == $value[$i]), $custom_html);
        }
    }

    return $html;
}

// Creates a form submit button

function form_submit($name = "submit", $value = "Submit", $custom_html = false, $class = "button")
{
    $id = form_unique_id();
    
    $html = "<input type=\"submit\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a form submit button using an image

function form_submit_image($image, $name = "submit", $value = "Submit", $custom_html = false, $class = false)
{
    $id = form_unique_id();
    
    $html = "<input name=\"$name\" value=\"$value\" id=\"$id\" ";
    $html.= "type=\"image\" src=\"". style_image($image). "\" ";

    if ($class) {
        $html.= "class=\"$class\" ";
    }

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a form reset button

function form_reset($name = "reset", $value = "Reset", $custom_html = false, $class = "button")
{
    $id = form_unique_id();

    $html = "<input type=\"reset\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// Creates a button with custom HTML, for onclick methods, etc.

function form_button($name, $value, $custom_html, $class="button")
{
    $id = form_unique_id();

    $html = "<input type=\"button\" name=\"$name\" id=\"$id\" value=\"$value\" class=\"$class\" ";

    if ($custom_html) {
        $custom_html = trim($custom_html);
        $html.= "$custom_html ";
    }

    $html.= "/>";
    return $html;
}

// create a form just to be a link button
// $var_array is an array (key, value pairs) containing names
// and values to be used for hidden form fields. Multi-dimensional
// arrays will be ignored.

function form_quick_button($href, $label, $var_array = false, $target = "_self")
{
    $webtag = get_webtag($webtag_search);

    $html = "<form method=\"get\" action=\"$href\" target=\"$target\">";
    $html.= form_input_hidden("webtag", _htmlentities($webtag));

    if (is_array($var_array)) {

        foreach($var_array as $var_name => $var_value) {

            if (!is_array($var_value)) {
            
                $html.= form_input_hidden($var_name, _htmlentities($var_value));
            }
        }
    }

    $html.= form_submit(form_unique_id(), $label);
    $html.= "</form>";

    return $html;
}

// create the date of birth dropdowns for prefs. $show_blank controls whether to show
// a blank option in each box for backwards compatibility with 0.3 and below,
// where the DOB was not required information

function form_dob_dropdowns($dob_year, $dob_month, $dob_day, $show_blank = true, $custom_html = "", $class = "bhselect")
{
    $lang = load_language_file();

    if ($show_blank) {

        $birthday_days = range(0, 31); $birthday_days[0] = '&nbsp;';
        $birthday_months = array_merge(array('&nbsp;'), $lang['month']);
        $birthday_years = array_flip(array_merge(array('&nbsp;' => ''), range(1900, date('Y', mktime()))));

    }else {

        $birthday_days = range(1, 31);
        $birthday_months = $lang['month'];
        $birthday_years = array_flip(range(1900, date('Y', mktime())));
    }

    array_walk($birthday_years, create_function('&$item, $key', 'if (is_numeric($key)) $item = $key;'));

    $output = form_dropdown_array("dob_day", $birthday_days, $dob_day, $custom_html, $class). "&nbsp;";
    $output.= form_dropdown_array("dob_month", $birthday_months, $dob_month, $custom_html, $class). "&nbsp;";
    $output.= form_dropdown_array("dob_year", $birthday_years, $dob_year, $custom_html, $class). "&nbsp;";

    return $output;
}

// Creates a dropdown selectors for dates
// including seperate fields for day, month and year.

function form_date_dropdowns($year = 0, $month = 0, $day = 0, $prefix = false, $start_year = 0)
{
    $lang = load_language_file();

    // the end of 2037 is more or less the maximum time that
    // can be represented as a UNIX timestamp currently

    if (is_numeric($start_year) && $start_year > 0 && $start_year < 2037) {

        $years = array_flip(array_merge(array('&nbsp;' => ''), range($start_year, 2037)));
        array_walk($years, create_function('&$item, $key', 'if (is_numeric($key)) $item = $key;'));

    }else {

        $years = array_flip(array_merge(array('&nbsp;' => ''), range(date('Y'), 2037)));
        array_walk($years, create_function('&$item, $key', 'if (is_numeric($key)) $item = $key;'));
    }

    $days = range(0, 31); $days[0] = '&nbsp;';
    $months = array_merge('&nbsp;'), $lang['month_short']);

    $output = form_dropdown_array("{$prefix}day", $days, $day). "&nbsp;";
    $output.= form_dropdown_array("{$prefix}month", $months, $month). "&nbsp;";
    $output.= form_dropdown_array("{$prefix}year", $years, $year). "&nbsp;";

    return $output;
}

?>