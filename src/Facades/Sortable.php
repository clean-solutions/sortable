<?php
namespace CleanSolutions\Sortable\Facades;

use Illuminate\Support\Facades\Facade;

class Sortable extends Facade {

    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sortable';
    }
}