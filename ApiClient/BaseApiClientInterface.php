<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient;

/**
 * Interface BaseApiClientInterface
 * @package App\ApiClient
 */
interface BaseApiClientInterface
{
    /**
     * @param string $requestMethod
     * @param string $apiMethod
     * @param array $parameters
     * @param array $data
     * @return mixed
     */
    function call(string $requestMethod, string $apiMethod, array $parameters, array $data);

    /**
     * @param string $apiMethod
     * @param array $parameters
     * @return mixed
     */
    function get(string $apiMethod, array $parameters);

    /**
     * @param string $apiMethod
     * @param array $parameters
     * @param array $data
     * @return mixed
     */
    function post(string $apiMethod, array $parameters, array $data);
}