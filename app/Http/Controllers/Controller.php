<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected function _returnMessage($content,$state,$data='')
    {
        return response()->json(
            array(
                'content'=>$content,
                'state'=>$state,
                'signal'=>$data
            )
        );
    }
    protected function _returnMessageFile($content,$state)
    {
        $result['state'] = $state;
        $result['content'] = $content;
        return json_encode($result);
    }
    protected function hide($keyword)
    {
        if (strstr($keyword, '@'))
        {
            $start = strpos($keyword, '@');
            $length = strlen($keyword);
            $keyword = substr($keyword, 0, 2) . '****' . substr($keyword, $start, $length - $start);
        }
        else
        {
            $keyword = substr($keyword, 0, 3) . '****' . substr($keyword, strlen($keyword) - 4, 4);
        }
        return $keyword;
    }
}