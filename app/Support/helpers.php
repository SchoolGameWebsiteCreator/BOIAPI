<?php

if (! function_exists('data_path')) {
    /**
     * Return the path to the data directory.
     * 
     * @param  string $path
     * @return string
     */
    function data_path($path = null)
    {
        return base_path('data').(is_null($path) ? '' : DIRECTORY_SEPARATOR.$path);
    }
}
