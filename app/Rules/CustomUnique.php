<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomUnique implements Rule
{
    private $model;
    private $column;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $column)
    {
        $this->model = $model;
        $this->column = $column;
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
        return $this->model::query()->where([[$this->column, $value], ['deleted_at', null]])->count() === 0;
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
