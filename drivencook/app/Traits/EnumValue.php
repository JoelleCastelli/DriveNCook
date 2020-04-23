<?php

namespace App\Traits;


use Illuminate\Support\Facades\DB;

trait EnumValue
{
    public function get_enum_column_values($table_name, $column_name)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table_name WHERE Field = '{$column_name}'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum_values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum_values = array_add($enum_values, $v, $v);
        }
        return $enum_values;
    }

}