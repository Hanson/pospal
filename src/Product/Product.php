<?php


namespace Hanson\Pospal\Product;


use Hanson\Pospal\Api;

class Product extends Api
{

    const QUERY_PRODUCT_PAGES_API = '/pospal-api2/openapi/v1/productOpenApi/queryProductPages';

    /**
     * 分页查询全部商品信息
     *
     * @param array $params
     * @return array
     */
    public function paginate($params = [])
    {
        return $this->request(self::QUERY_PRODUCT_PAGES_API, $params);
    }

}