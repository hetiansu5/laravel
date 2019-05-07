<?php

namespace App\Http\ApiControllers\User;

use App\Http\ApiControllers\Controller;
use App\Models\UserModel;

class UserController extends Controller
{

    public function getInfo()
    {
        $data = UserModel::getOne(1);
        return $this->response($data);
    }

}
