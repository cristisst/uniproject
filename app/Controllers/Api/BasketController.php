<?php

namespace App\Controllers\Api;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Database\Sqlite\Connection;
use App\Core\Http\Routing\Request;
use App\Traits\InteractWithBasket;
use App\Traits\InteractWithProduct;
use Exception;

class BasketController
{
    use InteractWithBasket;
    use InteractWithProduct;
    protected Connection $db;
    protected Model $user;

    protected array $data = [];

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->user = new Model();
        $this->user->id='1';
        $this->user->name='Test User';
    }

    /**
     * @throws Exception
     */
    public function addProduct(Request $request): array
    {
        if (!empty($request->getPostData() && array_key_exists('product_id', $request->getPostData()))){
            $productId = $request->getPostData()['product_id'];
        } else {
            throw new Exception('Product id is missing');
        }

        //Check if user has a basket opened otherwise create one and send the object
        $basket = $this->basket();

        $product = $this->fetchProduct($productId);

        if ($this->addProductToBasket($basket->id, $product->id)) {
            $this->data['product'] = $product->getAttributes();
        } else {
            $this->data['error'] = "Product $productId is not in the basket.";
        }
        return $this->data;
    }

    /**
     * @throws Exception
     */
    public function deleteProduct(Request $request, int $productId): array
    {
        if ($this->removeProductFromBasket($this->basket()->id, $productId)) {
            $this->data['success'] = "Product $productId removed from the basket.";
        } else {
            $this->data['error'] = "Product $productId is not in the basket.";
        }
        return $this->data;
    }

    /**
     * @throws NotFoundException
     * @throws ContainerException
     * @throws Exception
     */
    public function updateProduct(Request $request, int $productId): array
    {
        if ($this->updateProductInBasket(
            $this->basket()->id,
            $productId,
            $request->getPostData()['quantity']
        )) {
            $this->data['success'] = "Product $productId updated in the basket.";
        }

        $this->data['basketItems'] = $this->getBasketProducts();

        $this->data['basketTotal'] = round(array_sum(array_column($this->data['basketItems'], 'total_price')), 2);

        return $this->data;
    }
}