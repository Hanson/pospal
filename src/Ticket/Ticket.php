<?php


namespace Hanson\Pospal\Ticket;


use Carbon\Carbon;
use Hanson\Pospal\Api;

class Ticket extends Api
{

    const QUERY_ALL_PAY_METHOD_API = '/pospal-api2/openapi/v1/ticketOpenApi/queryAllPayMethod';
    const QUERY_TICKET_BY_SN_API = '/pospal-api2/openapi/v1/ticketOpenApi/queryTicketBySn';
    const QUERY_TICKET_PAGES_API = '/pospal-api2/openapi/v1/ticketOpenApi/queryTicketPages';

    /**
     * 查询支付方式代码
     *
     * @return array
     */
    public function allPayMethod()
    {
        return $this->request(self::QUERY_ALL_PAY_METHOD_API);
    }

    /**
     * 根据单据序列号查询
     *
     * @param $sn
     * @return array
     */
    public function query($sn)
    {
        return $this->request(self::QUERY_TICKET_BY_SN_API, ['sn' => $sn]);
    }

    /**
     * 分页查询所有单据
     *
     * @param $params
     * @return array
     */
    public function paginate($params = [])
    {
        $params = $params ?: [
            'startTime' => Carbon::yesterday()->toDateTimeString(),
            'endTime' => Carbon::yesterday()->endOfDay()->toDateTimeString(),
        ];

        return $this->request(self::QUERY_TICKET_PAGES_API, $params);
    }

    /**
     * 获取全部订单
     * @todo 奇怪的签名错误
     *
     * @param array $params
     * @return array
     */
    public function all($params = [])
    {
        $result = [];

        while (true) {
            $tickets = $this->paginate($params);

            if ($tickets['status'] === 'success' && $tickets['data']['pageSize'] === 100) {
                $result[] = array_merge($result, $tickets['data']['result']);
                $params['postBackParameter'] = $tickets['data']['postBackParameter'];
            } else {
                return $result;
            }
        }
    }

}