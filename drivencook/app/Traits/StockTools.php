<?php


namespace App\Traits;


use App\Models\FranchiseeStock;

trait StockTools
{
    public function get_franchisee_stock($dish_id, $franchisee_id)
    {
        $franchisee_stock = FranchiseeStock::where([
            ['dish_id', $dish_id],
            ['user_id', $franchisee_id]
        ])->first();

        if ($franchisee_stock != null) {
            $franchisee_stock = $franchisee_stock->toArray();
        }

        return $franchisee_stock;
    }
    
}