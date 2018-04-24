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

//        print_r($params);

        $this->signature = strtoupper(md5($this->appKey.json_encode($params)));

        $response = $this->getHttp()->json($this->url . $path, $params);

        $result = json_decode((string)$response->getBody(), true);

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
        $this->http->addMiddleware($this->headerMiddleware([
            'User-Agent'   => 'openApi',
            'Accept-Encoding' => 'gzip,deflate',
            'time-stamp' => time(),
            'data-signature' => $this->signature
        ]));
    }


}