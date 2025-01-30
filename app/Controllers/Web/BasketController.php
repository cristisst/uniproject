<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Http\Routing\Request;
use App\Traits\InteractWithBasket;
use App\Traits\InteractWithProduct;
use Exception;

class BasketController extends BaseController
{
    use InteractWithBasket;
    use InteractWithProduct;

    /**
     * Remove a product from the basket.
     *
     * @param Request $request
     * @param int $productId
     * @return string|null
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function removeProduct(Request $request, int $productId): ?string
    {
        if (isset($_SESSION['basket'][$productId])) {
            unset($_SESSION['basket'][$productId]);
            $this->data['success'] = "Product $productId added to the basket. Quantity: " . $_SESSION['basket'][$productId]['quantity'];
        } else {
            $this->data['error'] = "Product $productId is not in the basket.";
        }

        $this->data['basket'] = $_SESSION['basket'];


        $this->data['basketTotal'] = array_sum(array_column($_SESSION['basket'], 'price'));

        return template()->render('view_basket.tpl.php', $this->data);
    }

    /**
     * Display the current contents of the basket.
     *
     * @return string|null
     * @throws ContainerException
     * @throws NotFoundException
     * @throws Exception
     */
    public function viewBasket(): ?string
    {
        $this->data['basketItems'] = $this->getBasketProducts();

        $this->data['basketTotal'] = round(array_sum(array_column($this->data['basketItems'], 'total_price')), 2);

        return template()->render('view_basket.tpl.php', $this->data);
    }
}