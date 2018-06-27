<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient;

/**
 * Class BaseApiClient
 * @package App\ApiClient
 */
abstract class BaseApiClient implements BaseApiClientInterface
{
    /**
     * Request type GET
     */
    const TYPE_GET = 'get';

    /**
     * Request type POST
     */
    const TYPE_POST = 'post';

    /**
     * @var array
     */
    protected static $headers = [
        'accept' => 'Accept: application/json'
    ];

    /**
     * @var string
     */
    protected $apiMethod;

    /**
     * @var array
     */
    protected $apiParams = [];

    /**
     * @param string $apiMethod
     * @param array $parameters
     * @return mixed
     */
    abstract protected function getApiUrl(string $apiMethod, array $parameters = []);

    /**
     * @return mixed
     */
    abstract protected function getApiParams();

    /**
     * @return string
     */
    abstract protected function determineHost();

    /**
     * @param string $requestMethod
     * @param string $apiMethod
     * @param array $parameters
     * @param array $data
     * @return mixed
     */
    public function call(string $requestMethod, string $apiMethod, array $parameters = [], array $data = [])
    {
        $url = $this->getApiUrl($apiMethod, $parameters);

        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, self::$headers);

        if ($requestMethod == self::TYPE_POST) {
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($process);
        curl_close($process);

        return $result;
    }

    /**
     * @param string $apiMethod
     * @param array $parameters
     * @return mixed
     */
    public function get(string $apiMethod, array $parameters = [])
    {
        return $this->call(self::TYPE_GET, $apiMethod, $parameters);
    }

    /**
     * @param string $apiMethod
     * @param array $parameters
     * @param array $data
     * @return mixed
     */
    public function post(string $apiMethod, array $parameters = [], array $data = [])
    {
        return $this->call(self::TYPE_POST, $apiMethod, $parameters, $data);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $data = $this->get($this->apiMethod, $this->getApiParams());

        return json_decode($data);
    }

}