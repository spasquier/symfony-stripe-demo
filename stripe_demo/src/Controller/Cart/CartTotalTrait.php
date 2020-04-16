<?php

namespace App\Controller\Cart;

trait CartTotalTrait
{
    public function getCartTotal($products, $quantities)
    {
        if (empty($products)) {
            return 0;
        }

        $total = 0;
        foreach ($products as $product) {
            $total += $product->getPrice() * $quantities[$product->getId()];
        }

        return $total;
    }
}
