<?php


namespace Hanson\Pospal\Customer;


use Hanson\Pospal\Api;

class Customer extends Api
{

    const QUERY_BY_NUMBER_API = '/pospal-api2/openapi/v1/customerOpenApi/queryByNumber';
    const QUERY_CUSTOMER_PAGES_API = '/pospal-api2/openapi/v1/customerOpenApi/queryCustomerPages';
    const QUERY_BY_UID_API = '/pospal-api2/openapi/v1/customerOpenApi/queryByUid';

    /**
     * 根据会员号查询会员
     *
     * @param $customerNum
     * @return array
     */
    public function queryByNum($customerNum)
    {
        return $this->request(self::QUERY_BY_NUMBER_API, ['customerNum' => $customerNum]);
    }

    /**
     * 根据会员在银豹系统的唯一标识查询
     *
     * @param $uid
     * @return array
     */
    public function queryByUid($uid)
    {
        return $this->request(self::QUERY_BY_UID_API, ['customerUid' => $uid]);
    }

    /**
     * 分页查询会员
     *
     * @param array $params
     * @return array
     */
    public function paginate($params = [])
    {
        return $this->request(self::QUERY_CUSTOMER_PAGES_API, $params);
    }

}