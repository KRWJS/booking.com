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



?>