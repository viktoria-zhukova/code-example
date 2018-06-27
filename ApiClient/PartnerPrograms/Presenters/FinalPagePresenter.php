<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient\PartnerPrograms\Presenters;

use App\Models\FinalPage;

/**
 * Class FinalPagePresenter
 * @package App\ApiClient\PartnerPrograms\Presenters
 */
class FinalPagePresenter extends Presenter
{
    /**
     * @return string
     */
    public function fullUrl() :string
    {
        $fullUrl = $this->model->full_url;
        $qs = $this->model->linked->brand->qs_mask;

        if (($pos = stripos($fullUrl, '#')) && !empty($qs))
        {
            $hash = substr($fullUrl, $pos);
            $url = str_replace($hash, '', $fullUrl);
            $fullUrl = $url . '?' . $qs . $hash;

        } elseif (!empty($qs))
            $fullUrl .= '?' . $this->model->linked->brand->qs_mask;

        return $fullUrl;
    }

    /**
     * @return array
     */
    public function linked() :array
    {
        $data['brand_id'] = $this->model->linked->brand_id;
        $data['deprecated_date'] = is_null($this->model->deprecated_date) ? null : \Carbon\Carbon::parse($this->model->deprecated_date)->format('Y-m-d');

        if ($this->model->linked_type === FinalPage::TYPE_LANDING)
        {
            $data['language'] = $this->model->linked->language->code ?? null;
            $data['dmp_code'] = $this->model->linked->dmp_code;
        }

        return $data;
    }

    /**
     * @return array|null
     */
    public function translations()
    {
        return $this->model->translations->map(function ($item) {
            return ['language' => $item->language->code, 'name' => $item->name];
        })->toArray();
    }

    /**
     * @return string|null
     */
    public function subidParam()
    {
        return !empty(($this->model->subid_param))
            ? $this->model->subid_param
            : $this->model->linked->brand->subid_param;
    }
}