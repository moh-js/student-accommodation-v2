<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomUnique implements Rule
{
    private $model;
    private $id;
    private $id_field;
    private $column;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $column, $id = null, $id_field = null)
    {
        $this->model = $model;
        $this->column = $column;
        $this->id = $id;
        $this->id_field = $id_field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->model::query()
        ->when($this->id, function ($query)
        {
            $query->where($this->id_field, '!=', $this->id);
        })
        ->where([[$this->column, $value], ['deleted_at', null]])
        ->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been used.';
    }
}
