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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'geshi.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';

// HTML Purifier to clean and validate HTML.
require_once BH_INCLUDE_PATH. '/htmlpurifier/HTMLPurifier.auto.php';

function html_purifier_error()
{
    return;
}

function fix_html($html)
{
    $bh_error_handler = set_error_handler('html_purifier_error');

    $config = HTMLPurifier_Config::createDefault();

    $config->set('HTML.Allowed',
        'a[href|title],
         abbr,
         acronym,
         address,
         area[shape|coords|href|alt|nohref],
         b,
         big,
         blockquote[cite],
         br[clear],
         caption,
         center,
         cite,
         col[span|width|char|charoff|valign],
         colgroup,
         dd,
         del[cite|datetime],
         dfn,
         dir,
         div[class],
         dl,
         dt,
         em,
         font[size|color|face],
         h1,
         h2,
         h3,
         h4,
         h5,
         h6,
         hr[size|width|noshade],
         i,
         iframe[width|height|scrolling|type|src|frameborder],
         img[src|width|height|alt|border|usemap|longdesc|vspace|hspace|ismap],
         ins[cite|datetime],
         li[type|start],
         map[name],
         marquee[direction|behavior|loop|scrollamount|scrolldelay|heigth|width|hspace|vspace],
         menu,
         ol[type|start],
         p,
         pre[width|class],
         q,
         s,
         samp,
         small,
         span[class],
         strike,
         strong,
         sub,
         sup,
         table[border|cellspacing|cellpadding|width|height|summary|bgcolor|background|frame|rules|bordercolor],
         tbody[char|charoff|valign],
         td[abbr|axis|background|bgcolor|char|charoff|colspan|height|headers|rowspan|scope|valign|width|nowrap],
         tfoot[char|charoff|valign],
         th[abbr|axis|background|bgcolor|char|charoff|colspan|height|headers|rowspan|scope|valign|width|nowrap],
         thead[char|charoff|valign],
         tr[bgcolor|char|charoff|valign],
         tt,
         u,
         ul[type|start],
         var,
         *[style|align|title]'
    );

    $config->set('CSS.AllowedProperties', array(
        'font-family',
        'font-style',
        'font-variant',
        'font-weight',
        'font-size',
        'font',
        'color',
        'background-color',
        'word-spacing',
        'letter-spacing',
        'text-decoration',
        'vertical-align',
        'text-transform',
        'text-align',
        'text-indent',
        'line-height',
        'margin-top',
        'margin-bottom',
        'margin-left',
        'margin-right',
        'margin',
        'padding-top',
        'padding-bottom',
        'padding-left',
        'padding-right',
        'padding',
        'border-top-width',
        'border-top-width',
        'border-right-width',
        'border-bottom-width',
        'border-left-width',
        'border-width',
        'border-color',
        'border-style',
        'border-top',
        'border-right',
        'border-bottom',
        'border-left',
        'border',
        'width',
        'height',
        'float',
        'clear',
        'white-space',
        'list-style-type',
        'list-style-image',
        'list-style-position',
        'list-style',
    ));

    $config->set('HTML.SafeObject', true);
    $config->set('Output.FlashCompat', true);

    $config->set('AutoFormat.AutoParagraph', true);
    $config->set('AutoFormat.Linkify', true);

    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp', '/^http(s)?:\/\/www\.youtube\.com\/embed\//');

    $purifier = new HTMLPurifier($config);

    $html = $purifier->purify($html);

    set_error_handler($bh_error_handler);

    return $html;
}

?>