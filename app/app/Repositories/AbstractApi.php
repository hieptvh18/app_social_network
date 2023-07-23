<?php
namespace App\Repositories;

abstract class AbstractApi
{

    public function respSuccess($dataParams,$message='')
    {
        if(!$dataParams || !is_array($dataParams) || !count($dataParams)){
            $dataParams = ['data'=>[]];
        }

        return response()->json([
            'success'=>true,
            'message'=>$message,
            array_keys($dataParams)[0] => array_values($dataParams)[0]
        ]);
    }

    public function respError($dataParams,$message=''){
        if(!$dataParams || !is_array($dataParams) || !count($dataParams)){
            $dataParams = ['data'=>[]];
        }
        
        return response()->json([
            'success'=>false,
            'message'=>$message,
            array_keys($dataParams)[0] => array_values($dataParams)[0]
        ]);
    }
}