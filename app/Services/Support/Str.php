<?php namespace App\Services\Support;

use Illuminate\Support\Str as baseClass;

/*
 * Extends the Str class
 * 
 */
class Str extends baseClass {
    
    /**
     * Generate a URL friendly "slug" from a given string.
     * Allow utf-8 characters
     *
     * @param  string  $title
     * @param  string  $separator
     * @return string
     */
    public static function slugutf8($title, $separator = '-')
    {
            // Convert all dashes/underscores into separator
            $flip = $separator == '-' ? '_' : '-';

            $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

            // Remove all characters that are not the separator, letters, numbers, or whitespace.
            $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

            // Replace all separator characters and whitespace by a single separator
            $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

            return trim($title, $separator);
    }
    
    /**
     * Remove all crap from a string
     *
     * @param  string  $string
     * @return string
     */
    public static function sanitize($string)
    {
            // remove HTML tags
            $string = strip_tags($string);
            
            // replace htmlentities and line breaks by a space
            $string = preg_replace("/&#?[a-z0-9]{2,8};|\r|\n/i", " ", $string);
            
            // remove consecutive spaces and tabs
            $string = preg_replace("/\s+/", " ", $string);
            
            return trim($string);
    }

    /**
     * Replace underscores by spaces and capitalize
     *
     * @param  string  $string
     * @return string
     */
    public static function beautify($string)
    {
        return ucfirst(str_replace('_', ' ', $string));
    }
}

