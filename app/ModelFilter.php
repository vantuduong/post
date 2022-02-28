<?php

namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ModelFilter
{
    public function scopeFilter(Builder $builder, array $data)
    {
        foreach ($data as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $method = 'filter' . Str::studly($field);

            if (method_exists($this, $method)) {
                $this->{$method}($builder, $value);
                continue;
            }

            if (isset($this->filters) && in_array($field, $this->filters)) {
                if (is_array($value)) {
                    $builder->whereIn("{$this->getTable()}.$field", $value);
                } else {
                    $builder->where("{$this->getTable()}.$field", $value);
                }
            }
        }
    }

    public function scopeSort(Builder $builder, ?string $sort)
    {
        if (empty($sort) || !preg_match('/,/', $sort)) {
            return;
        }

        $sortable = $this->sortable ?? [];
        [$field, $direction] = explode(',', $sort);

        $method = 'sort' . Str::studly($field);

        if (method_exists($this, $method)) {
            $this->{$method}($builder);
            return;
        }

        if ((in_array($field, $sortable) || $field = Arr::get($sortable, $field)) && in_array(Str::lower($direction), ['asc', 'desc'])) {
            $builder->orderBy($field, $direction);
        }
    }
}
