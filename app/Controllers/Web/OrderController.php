<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Traits\InteractWithBasket;
use App\Traits\InteractWithOrder;
use Exception;

class OrderController extends BaseController
{
    use InteractWithBasket;
    use InteractWithOrder;
    /**
     * @throws ContainerException|NotFoundException|Exception
     */
    public function create()
    {
        //grab the basket
        $basket = $this->basket();

        $products = $this->getBasketProducts();

        $basketTotalPrice = round(array_sum(array_column($products, 'total_price')), 2);

        $orderId = $this->insertOrder(
            $this->user->id,
            $basketTotalPrice
        );

        $this->insertOrderProducts($products, $orderId);

        $this->clearBasket($basket->id);

        //fetch the order
        $this->data['order'] = $this->getOrderWithItems($orderId);

        return template()->render('order.tpl.php', $this->data);
    }


}