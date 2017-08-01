<?php

if (!function_exists('sortable'))
{
    /**
     * Generate a HTML link.
     *
     * @param string $column
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     * @param bool   $escape
     *
     * @return string
     */
    function sortable($column, $title = null, $parameters = [], $attributes = [], $escape = true)
    {
        return app('sortable')->renderLink($column, $title, $parameters, $attributes, $escape);
    }
    
}

?>