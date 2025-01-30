<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Http\Routing\Request;
use App\Traits\HasSorting;
use App\Traits\InteractWithProduct;

class CategoryController extends BaseController
{
    use HasSorting;
    use InteractWithProduct;
    /**
     * @throws NotFoundException
     * @throws ContainerException
     */
    public function show(Request $request, $id)
    {
        $sql = 'SELECT * FROM categories WHERE id = ' . $id;
        $query = $this->db->query($sql);
        $result = $query->fetchObject(Model::class);
        if ($result) {
            $this->data['category'] = $result->getAttributes();
            $this->data['products'] = $this->fetchProductByCategory($id, $request->getQueryParams());
            return template()->render('category.tpl.php', $this->data);
        }
        throw new NotFoundException('Category not found');
    }
}