<?php

namespace App\ApiClient\PartnerPrograms;

use App\ApiClient\PartnerPrograms\Base\ApiClient;
use App\ApiClient\PartnerPrograms\Presenters\BrandPresenter;
use App\Models\Brand;
use App\Models\PartnerProgram;

/**
 * Class ProjectsApi
 * @package App\ApiClient\PartnerPrograms
 */
class BrandsApi extends ApiClient
{
    /**
     * @var array
     */
    protected $apiParams = ['method' => 'projects'];

    /**
     * @param Brand $brand
     * @param PartnerProgram $partnerProgram
     * @throws \Exception
     */
    public function send(Brand $brand, PartnerProgram $partnerProgram)
    {
        $this->setPartnerProgram($partnerProgram->toArray());

        $request = $this->decorate($brand);

        $this->setApiParams($request);

        $response = $this->execute();

        if (!isset($response->result) || $response->result === false)
            throw new \Exception($response->message ?? 'Bad Response');
    }

    /**
     * @param Brand $brand
     * @return array
     */
    public function decorate(Brand $brand) : array
    {
        $brand = new BrandPresenter($brand);

        $data = [
            'id' => $brand->id,
            'url' => $brand->url,
            'tags' => $brand->tags(),
            'name' => $brand->name,
            'image' => $brand->image,
            'status' => $brand->status,
            'qs_mask' => $brand->qs_mask,
            'dmp_prod' => $brand->dmp_prod,
            'cashbox_id' => $brand->cashbox_id,
            'sort_order' => $brand->sortOrder($this->partnerProgram['id']),
            'subid_param' => $brand->subid_param,
            'description' => $brand->description
        ];

        $request['data']  = json_encode($data);
        $request['method'] = 'brand';

        return $request;
    }
}