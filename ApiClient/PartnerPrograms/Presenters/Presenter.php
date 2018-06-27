<?php
/**
 * @author: Viktoria Zhukova <v.zhukova@lucky-labs.com>
 */

namespace App\ApiClient\PartnerPrograms\Presenters;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Presenter
 * @package App\ApiClient\PartnerPrograms\Presenters
 */
abstract class Presenter
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Presenter constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->model->{$name};
    }

    /**
     * @return array|null
     */
    public function tags()
    {
        return $this->model->tags->map(function ($item) {
            return ['name' => strtolower($item->name)];
        })->toArray();
    }
}