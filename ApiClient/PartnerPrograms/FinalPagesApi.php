<?php

namespace App\ApiClient\PartnerPrograms;

use App\ApiClient\PartnerPrograms\Base\ApiClient;
use App\ApiClient\PartnerPrograms\Presenters\FinalPagePresenter;
use App\Models\FinalPage;
use App\Models\PartnerProgram;

/**
 * Class FinalPagesApi
 * @package App\ApiClient\PartnerPrograms
 */
class FinalPagesApi extends ApiClient
{
    /**
     * @param FinalPage $finalPage
     * @param PartnerProgram $partnerProgram
     * @throws \Exception
     */
    public function send(FinalPage $finalPage, PartnerProgram $partnerProgram)
    {
        $this->setPartnerProgram($partnerProgram->toArray());

        $parameters = $this->decorate($finalPage);

        $this->setApiParams($parameters);

        $response = $this->execute();

        if ($response->result === false)
            throw new \Exception($response->message);
    }

    /**
     * @param FinalPage $finalPage
     * @return array
     */
    public function decorate(FinalPage $finalPage): array
    {
        $finalPage = new FinalPagePresenter($finalPage);

        $data = [
            'id' => $finalPage->id,
            'tags' => $finalPage->tags(),
            'image' => $finalPage->image,
            'linked' => $finalPage->linked(),
            'status' => $finalPage->status,
            'full_url' => $finalPage->fullUrl(),
            'sort_order' => $finalPage->sort_order,
            'subid_param' => $finalPage->subidParam(),
            'linked_type' => $finalPage->linked_type,
            'translations' => $finalPage->translations()
        ];

        $parameters['data'] = json_encode($data);
        $parameters['method'] = 'final-page';

        return $parameters;
    }
}