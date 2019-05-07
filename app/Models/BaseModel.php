<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * 获取单个ID记录
     *
     * @param int $id
     * @return mixed
     */
    public static function getOne($id)
    {
        return static::query()->where('id', $id)->first();
    }

    /**
     * 获取多个ID记录
     *
     * @param array $idArr
     * @return mixed
     */
    public static function getMulti($idArr)
    {
        return static::query()->whereIn('id', $idArr)->get();
    }

}


