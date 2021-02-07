<?php

/**
 * Determine if the visitor is in China or not
 */
function is_in_china() {
    $location = GeoIP::getLocation(Request::getClientIp(true));

    return isset($location['country']) && $location['country'] == 'China';
}

/**
 * Get a formatted timestamp
 */
function format_timestamp($time, $format = 'default') {
    $timeFormat = "%b %e, %Y";

    // allow for more format choices to be added
    switch ($format) {
        case 'short':
            break;
    }

    return strftime($timeFormat, $time->getTimestamp());
}

/**
 * Get a formatted timestamp
 */

function filter_html_tag($content){
	$content = htmlspecialchars_decode($content);
	$content = str_replace('<br>', '', $content);
	$content = str_replace('<p>&nbsp;</p>', '<p></p>', $content);
	$content = str_replace('<span style="font-weight: 400;">', '', $content);
	$content = str_replace('</span>', '', $content);
	$content = str_replace('<u>', '', $content);
	$content = str_replace('</u>', '', $content);
	$content = str_replace('<p><br>&nbsp;</p>', '<p></p>', $content);
	$content = str_replace('<p><strong>&nbsp;</strong></p>', '<p></p>', $content);
	$content = str_replace('<p><br />&nbsp;</p>', '<p></p>', $content);
	$content = str_replace('<p> </p>', '<p></p>', $content);
	$content = str_replace('style="text-decoration: underline;"', '', $content);

	return $content;

}

