<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient\PartnerPrograms\Presenters;

/**
 * Class FinalPagePresenter
 * @package App\ApiClient\PartnerPrograms\Presenters
 */
class BrandPresenter extends Presenter {

    /**
     * @param $partnerProgramId
     * @return int
     */
    public function sortOrder($partnerProgramId) :int
    {
        return optional(\DB::table('brand_partner_program')
            ->where('partner_program_id', $partnerProgramId)
            ->where('brand_id', $this->model->id)
            ->first())->sort_order;
    }
}