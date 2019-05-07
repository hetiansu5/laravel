<?php

namespace App\Http\ApiControllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function response($data, $code = 0, $message = '')
    {
        return response()->json(['code' => $code, 'message' => $message, 'data' => $data]);
    }

    public function error(Exception $e)
    {
        $data = [];
        $code = $e->getCode();
        $message = $e->getMessage();
        return $this->response($data, $code, $message);
    }
}
