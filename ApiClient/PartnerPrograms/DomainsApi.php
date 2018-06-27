<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient\PartnerPrograms;

use App\ApiClient\PartnerPrograms\Base\ApiClient;

/**
 * Class DomainsApi
 * @package App\ApiClient\PartnerPrograms
 */
class DomainsApi extends ApiClient
{
    /**
     * @var array
     */
    protected $apiParams = ['method' => 'landings'];
}