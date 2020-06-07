<?php

return [
    $GLOBALS['DISH_TYPE'] = [
        'hot_dish' => 'warehouse_dishes.hot_dish',
        'cold_dish' => 'warehouse_dishes.cold_dish',
        'salty_snack' => 'warehouse_dishes.sweet_snack',
        'sweet_snack' => 'warehouse_dishes.salty_snack',
        'drink' => 'warehouse_dishes.drink',
    ],
    $GLOBALS['PURCHASE_ORDER_STATUS'] = [
        'created' => 'warehouse_order.created',
        'in_progress' => 'warehouse_order.in_progress',
        'sent' => 'warehouse_order.sent',
        'received' => 'warehouse_order.received',
    ],
    $GLOBALS['SALE_STATUS'] = [
        'pending' => 'client/sale.pending',
        'done' => 'client/sale.done',
    ],
    $GLOBALS['SALE_PAYMENT_METHOD'] = [
        'Carte bancaire' => 'client/sale.credit_card',
        'Liquide' => 'client/sale.cash',
    ],
];
