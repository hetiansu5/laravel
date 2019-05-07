<?php

namespace App\Models;


class UserModel extends BaseModel
{
    protected $table = 'user';

    /**
     * 执行模型是否自动维护时间戳.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    const SMS_SWITCH_ON = 1;
    const SMS_SWITCH_OFF = 0;

}
