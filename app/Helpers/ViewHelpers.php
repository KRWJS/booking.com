<?php

/**
 * Give active CSS class to nav item
 *
 * @param $string
 * @return string
 */
function is_active_menu($string) {
    return (Route::getCurrentRoute() != null && strpos(Route::getCurrentRoute()->getName(), $string) !== false || $string === Request::url()) ? 'is-active' : '';
}

/**
 *
 *
 * @param $string
 * @param array $submenu
 * @return mixed
 */
function print_submenu($string, $submenu) {
    if (is_array($submenu) && strpos(Route::getCurrentRoute()->getName(), $string) !== false && !is_null($submenu)) {
        return View::make('partials.submenu')->with(['submenu' => $submenu]);
    }
}

/**
 * Add a query string to assets
 * If bustquery is false, the query string will be added to the name
 */
function cached_asset($path, $bustQuery = true)
{
    // Get the full path to the asset.
    $realPath = public_path($path);

    if ( ! file_exists($realPath)) {
        // no hard error, just return path
        return asset($path);
        //throw new LogicException("File not found at [{$realPath}]");
    }

    // Get the last updated timestamp of the file.
    $timestamp = filemtime($realPath);

    if ( ! $bustQuery) {
        // Get the extension of the file.
        $extension = pathinfo($realPath, PATHINFO_EXTENSION);

        // Strip the extension off of the path.
        $stripped = substr($path, 0, -(strlen($extension) + 1));

        // Put the timestamp between the filename and the extension.
        $path = implode('.', array($stripped, $timestamp, $extension));
    } else {
        // Append the timestamp to the path as a query string.
        $path  .= '?' . $timestamp;
    }

    return asset($path);
}

/**
 * get all file names in a directory
 *
 * @param $dir
 * @return array
 */
function fetch_file_names($dir, $showExtension = false)
{
    $filesNames = [];
    $files = File::files($dir);

    foreach($files as $file) {
        if ($showExtension) {
            $fileName = substr($file, strlen($dir) + 1);
            $filesNames[$fileName] = $fileName;
        }
        else {
            // strip off extension and the extra .blade extension as well
            $fileName = str_replace('.blade', '', pathinfo($file)['filename']);
            $filesNames[$fileName] = $fileName;
        }
    }

    return $filesNames;
}