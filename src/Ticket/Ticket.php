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
     * @throws \Hanson\Pospal\HttpException
     */
    public function paginate($params = [])
    {
        $params['startTime'] = $params['startTime'] ?? Carbon::yesterday()->toDateTimeString();
        $params['endTime'] = $params['endTime'] ?? Carbon::yesterday()->endOfDay()->toDateTimeString();

        return $this->request(self::QUERY_TICKET_PAGES_API, $params);
    }

    /**
     * 获取全部订单
     *
     * @param array $params
     * @param \Closure $callback
     * @return void
     * @throws \Hanson\Pospal\HttpException
     */
    public function all($params = [], \Closure $callback)
    {
        $params['postBackParameter'] = null;

        while (true) {
            $tickets = $this->paginate($params);

            $callback($tickets['data']['result']);

            if ($tickets['status'] === 'success' && count($tickets['data']['result']) === $tickets['data']['pageSize']) {

                $params['postBackParameter'] = ($tickets['data']['postBackParameter']);

            } else {
                return;
            }
        }
    }

}