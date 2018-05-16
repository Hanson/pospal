<?php


namespace Hanson\Pospal;


use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{

    protected $appId;

    protected $appKey;

    protected $signature;

    protected $url;

    public function __construct($appId, $appKey, $url)
    {
        $this->appId = $appId;
        $this->url = $url;
        $this->appKey = $appKey;
    }

    /**
     * 请求接口
     *
     * @param $path
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function request($path, $params = [])
    {
        $params['appId'] = $this->appId;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "User-Agent: openApi",
            "Content-Type: application/json; charset=utf-8",
            "accept-encoding: gzip,deflate",
            "time-stamp: ".time(),
            "data-signature: ".strtoupper(md5($this->appKey.json_encode($params)))
        ]);
        curl_setopt($curl, CURLOPT_URL, $this->url . $path);         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));		// Post提交的数据包
        curl_setopt($curl, CURLOPT_POST, 1);		// 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回

        $output = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new HttpException(curl_error($curl));
        }

        curl_close($curl);

        $result = json_decode($output, true);

        $this->checkAndThrow($result);

        return $result;
    }

    /**
     * 检查错误
     *
     * @param $result
     * @throws HttpException
     */
    private function checkAndThrow($result)
    {
        if ($result['status'] === 'error') {
            throw new HttpException($result['messages'][0], $result['errorCode']);
        }
    }

    /**
     * 添加请求 header
     */
    public function middlewares()
    {
    }


}