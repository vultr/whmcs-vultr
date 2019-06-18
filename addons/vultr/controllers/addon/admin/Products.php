<?php

namespace MGModule\vultr\controllers\addon\admin;

use MGModule\vultr as main;

/**
 * Description of Products
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class Products extends main\mgLibs\process\AbstractController {

    public function indexHTML($input = [], $vars = []) {

        return array
            (
            'tpl'  => 'products',
            'vars' => $vars
        );
    }

    public function getProductListJSON($input = [], $vars = []) {

        $products = new \MGModule\vultr\models\products\Repository();
        $vars['recordsFiltered'] = $vars['recordsTotal'] = $products->countProducts();
        $columnOrder = array(
            'name',
            'groupName',
            'configoption2',
            'paytype'
        );
        $products->orderByProducts($columnOrder[$input['order']['column']], $input['order']['dir']);
        $products->limitProducts($input['limit']);
        $products->offset($input['offset']);
        $vars['data'] = [];
        foreach ($products->getProducts() as $item) {

            $vars['data'][] = $this->formatProductsRow($item);
        }
        return $vars;
    }

    private function formatProductsRow($item) {

        $data = get_object_vars($item); //Convert to Array
        $rows = $this->dataTablesParseRow('row', $data);

        return $rows;
    }

    public function removeProductJSON($input = [], $vars = []) {
        $products = new \MGModule\vultr\models\products\Repository();
        $removeInfo = $products->removeProduct($input['productId']);
        if ($removeInfo == 'success') {
            return array
                (
                'success' => 'Product has been removed.'
            );
        } else {
            return array
                (
                'error' => 'Action Failed.'
            );
        }
    }

}
