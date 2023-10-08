<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class Helper
{
    public static function getCollectionColumnValues(Collection $collection, string $column='')
    {
        $result = [];
        
        if( !empty($column) ) {
            $items = $collection->all();
            if( count($items) > 0 ) $result = array_column($items, $column);
        }

        return $result;
    }
}
