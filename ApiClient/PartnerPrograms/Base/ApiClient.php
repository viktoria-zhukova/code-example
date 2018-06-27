<?php

namespace App\ApiClient\PartnerPrograms\Base;

use App\ApiClient\BaseApiClient;

/**
 * Class Api
 * @package App\PartnerProgram\Base
 */
abstract class ApiClient extends BaseApiClient
{
    /**
     * @var array
     */
    protected $partnerProgram;

    /**
     * @var string
     */
    protected $apiPrefix = 'asxsadas';

    /**
     * @var
     */
    protected $apiMethod = 'api';

    /**
     * @param $code
     * @return ApiClient
     */
    public function setPartnerProgramCode($code)
    {
        $partnerProgram = config('partner_programs.list.'.$code);
        return $this->setPartnerProgram($partnerProgram);
    }

    /**
     * @param mixed $partnerProgram
     * @return $this
     */
    public function setPartnerProgram($partnerProgram)
    {
        $this->partnerProgram = $partnerProgram;
        return $this;
    }

    /**
     * @param array $apiParams
     */
    public function setApiParams(array $apiParams)
    {
        $this->apiParams = $apiParams;
    }

    /**
     * @return array
     */
    protected function getApiParams()
    {
        ksort($this->apiParams);

        $sign = md5(http_build_query($this->apiParams) . config('partner_programs.key'));

        $hashParam = ['sign' => $sign];

        return array_merge($this->apiParams, $hashParam);
    }


    /**
     * @param string $apiMethod
     * @param array $parameters
     * @return string
     */
    protected function getApiUrl(string $apiMethod, array $parameters = [])
    {
        $url = sprintf('%s/%s', $this->determineHost(), $this->apiPrefix);

        if ($apiMethod) {
            $url .= sprintf('/%s', $apiMethod);
        }

        if (!empty($parameters))
            $url .= sprintf('?%s', http_build_query($parameters));

        return $url;
    }

    /**
     * @return string
     */
    protected function determineHost() :string
    {
        if (app()->environment('staging', 'local'))
            $host = config('partner_programs.list.'.$this->partnerProgram['code_name'].'.staging_url');
        else
            $host = $this->partnerProgram['api_url'];

        return $host;
    }

    /**
     * @param $programData
     * @return mixed
     */
    public function getAll($programData)
    {
        $this->setPartnerProgram($programData);

        $data = $this->execute();

        return $data;
    }
}