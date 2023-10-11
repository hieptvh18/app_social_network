<?php
namespace App\Http\Controllers\Api;

abstract class AbstractApi
{

    /**
     * Response json type success
     */
    public function respSuccess($dataParams,$message='',$statusCode = 200)
    {
        if(!$dataParams || !is_array($dataParams) || !count($dataParams)){
            $dataParams = ['data'=>[]];
        }

        return response()->json([
            'success'=>true,
            'message'=>$message,
            array_keys($dataParams)[0] => array_values($dataParams)[0]
        ],$statusCode);
    }

    /**
     * Response json type error
     */
    public function respError($dataParams,$message='',$statusCode = 200){
        if(!$dataParams || !is_array($dataParams) || !count($dataParams)){
            $dataParams = ['data'=>[]];
        }

        return response()->json([
            'success'=>false,
            'message'=>$message,
            array_keys($dataParams)[0] => array_values($dataParams)[0]
        ],$statusCode);
    }
}
