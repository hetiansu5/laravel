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
     * @param array $columns
     * @return mixed
     */
    public static function getOne($id, $columns = ["*"])
    {
        return static::query()->find($id, $columns);
    }

    /**
     * 获取多个ID记录
     *
     * @param array $idArr
     * @param array $columns
     * @return mixed
     */
    public static function getMulti($idArr, $columns = ["*"])
    {
        return static::query()->whereIn('id', $idArr)->get($columns);
    }

}


