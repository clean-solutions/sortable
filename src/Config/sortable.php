<?php

return [
    
    // request parameters
    'column'        => [
        'sort'      => 'sort',
        'order'     => 'order',
        'page'      => 'page'
    ],

    // icon settings
    'icon'          => [
        'is_class'  => false,
        'clickable' => false,   //generated icon is clickable (by default non-clickable)

        'asc'       => '&#8593;',
        'desc'      => '&#8595;',
        'default'   => '&#8597;'
    ],
    
    // text formatting
    'formatting'    => [
        'text_and_icon_separator' => ' ',
    ],

    // direction settings
    'direction'     => [
        'default' => 'asc',
        'default_unsorted' => 'asc' // use only in views
    ],
];
