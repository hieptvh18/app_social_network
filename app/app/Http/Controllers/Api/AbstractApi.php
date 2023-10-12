<?php
namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;

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

    /**
     * @param array $data
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function json($data = [], $status = 200)
    {
        try {
            return response()->json($data, $status);
        } catch (ApiException $e) {
            report($e);
            // Log::channel('slack')->error($this->getMessage(), [$this->getCode()]);
            $code = $this->getCode();
            $msg = $this->getMessage();
            $results = [
                "message" => $msg,
                "code" => $code
            ];
            return response()->json([
                'errors' => $results
            ]);
        }
    }
}
