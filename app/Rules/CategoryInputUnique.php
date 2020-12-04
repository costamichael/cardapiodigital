<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class CategoryInputUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $categoria = request('categoria', 0);
        $id = (int)request('id', 0);
        $result = DB::table('insumos')
            ->where('insumo', '=', $value)
            ->where('categoria', '=', $categoria);
        if ($id === 0) {
            return $result->count() === 0;
        }
        $model = $result->first();
        if ($model) {
            return $model->id === $id;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O insumo que você tentou cadastrar já existe.';
    }
}
