<?php
namespace CleanSolutions\Sortable\Helpers;

class Sortable
{
    // request parameters
    protected $sort = 'sort';
    protected $order = 'order';
    protected $page = 'page';

    // icon settings
    protected $is_class = false;
    protected $asc_icon = '&#8593;';
    protected $desc_icon = '&#8595;';
    protected $default_icon = '&#8597;';
    protected $is_clickable = false;

    // text and icon separator
    protected $separator = ' ';

    // direction settings
    protected $default_direction = 'asc';

    public function __construct()
    {
        $this->sort = config('sortable.column.sort', $this->sort);
        $this->order = config('sortable.column.order', $this->order);
        $this->page = config('sortable.column.page', $this->page);

        $this->asc_icon = config('sortable.icon.asc', $this->asc_icon);
        $this->desc_icon = config('sortable.icon.desc', $this->desc_icon);
        $this->default_icon = config('sortable.icon.default', $this->default_icon);
        $this->is_class = config('sortable.icon.is_class', $this->is_class);

        $this->is_clickable = config('sortable.icon.clickable', $this->is_clickable);
        $this->separator = config('sortable.formatting.text_and_icon_separator', $this->separator);

        $this->default_direction = config('sortable.direction.default_unsorted', $this->default_direction);
    }

    public function renderLink($column, $title = null, $parameters = [], $attributes = [], $escape = true)
    {
        $this->fixArray($parameters);
        $this->fixArray($attributes);

        $this->title($title, $column);

        if (is_bool($escape) && $escape) {
            $title = htmlentities($title, ENT_QUOTES, 'UTF-8', false);
        }

        $icon = $this->default_icon;

        $direction = $this->direction($column, $icon);

        $endOfTags = '';
        $this->tagFormatting($title, $icon, $endOfTags);

        $this->parameters($column, $direction, $parameters);
        $url = url(request()->path() . '?' . http_build_query($parameters));

        return '<a href="' . $url . '"' . $this->attributes($attributes) . '>' . $title . '</a>' . $endOfTags;
    }

    private function tagFormatting(&$title, &$icon, &$endOfTags)
    {
        if(is_bool($this->is_class) && $this->is_class){
            $icon = '<i class="'.$icon.'"></i>';
        }

        if($this->is_clickable){
            $endOfTags = '';
            $title .= $this->separator . $icon;
        } else {
            $endOfTags = $this->separator . $icon;
        }
    }

    private function fixArray(&$array)
    {
        $array = (is_null($array) || is_bool($array)) ? [] : $array;
    }

    private function title(&$title = null, $default = null)
    {
        if (is_null($title) || $title === false) {
            $title = $default;
        }
    }

    private function direction($column, &$icon)
    {
        $sort = request()->get($this->sort);
        $order = request()->get($this->order);
        
        if ($sort == $column && in_array($order, ['asc', 'desc'])) {
            $icon = ($order === 'asc' ? $this->asc_icon : $this->desc_icon);
            return ($order === 'desc' ? 'asc' : 'desc');
        }

        return $this->default_direction;
    }

    private function parameters($column, $direction, array &$parameters = [])
    {
        $parameters = array_merge(request()->except($this->sort, $this->order, $this->page), $parameters);

        $parameters = array_filter($parameters, function ($value) {
            return is_array($value) ? (count($value) > 0) : (strlen($value) > 0);
        });

        array_set($parameters, $this->sort, $column);
        array_set($parameters, $this->order, $direction);
    }

    private function attributes($attributes)
    {
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            if (!is_null($element = $this->attributeElement($key, $value))) {
                $html[] = $element;
            }
        }

        return (count($html) > 0) ? (' ' . implode(' ', $html)) : '';
    }

    private function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        if (is_bool($value) && $key != 'value') {
            return $value ? $key : null;
        }

        if (!is_null($value)) {
            return $key . '="' . e($value) . '"';
        }
        
        return null;
    }
}
