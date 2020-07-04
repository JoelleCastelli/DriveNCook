<?php


namespace App\Traits;


use App\Models\SoldDish;

trait SaleTools
{
    public function get_sale_price($sale_id)
    {

        $sold_dishes = SoldDish::where(['sale_id', $sale_id])
            ->get();

        $sum = 0;
        foreach($sold_dishes as $sold_dish) {
            $sum += $sold_dish->unit_price;
        }

        return $sum;
    }
    
}