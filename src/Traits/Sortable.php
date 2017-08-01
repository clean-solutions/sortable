<?php
namespace CleanSolutions\Sortable\Traits;

use Illuminate\Support\Facades\Schema;

/**
 * Sortable trait.
 */
trait Sortable
{
    protected $sort = 'sort';
    protected $order = 'order';
    
    protected $default_direction = 'asc';

    public function scopeSortable($query, $column = null, $direction = null)
    {
        $this->sort = config('sortable.column.sort', 'sort');
        $this->order = config('sortable.column.order', 'order');
        
        $this->default_direction = config('sortable.direction.default', 'asc');

        if (request()->has($this->sort)) {
            return $this->querySortableOrder($query, request()->get($this->sort), request()->get($this->order));
        } elseif (!is_null($column)) {
            return $this->querySortableOrder($query, $column, $direction);
        } else {
            return $query;
        }
    }

    private function querySortableOrder($query, $column, $direction = null)
    {
        $direction = $this->getDirection($direction);

        request()->merge([
            $this->sort => $column,
            $this->order => $direction
        ]);

        if (method_exists($this, camel_case($column).'Sortable')) {
            return call_user_func_array([$this, camel_case($column).'Sortable'], [$query, $direction]);
        }

        if (isset($this->sortableAs) && in_array($column, $this->sortableAs)) {
            $query = $query->orderBy($column, $direction);
        } elseif($this->columnExists($column)) {
            $query = $query->orderBy($column, $direction);
        }
        
        return $query;
    }

    private function columnExists($column)
    {
        $columns = isset($this->sortable) ? $this->sortable : (isset($this->fillable) ? $this->fillable : null);

        return is_array($columns) ? in_array($column, $columns) : Schema::hasColumn($this->getTable(), $column);
    }

    private function getDirection($direction = null)
    {
        if (is_null($direction) || !in_array($direction, ['asc', 'desc'])) {
            return $this->default_direction;
        }
        return $direction;
    }
}
