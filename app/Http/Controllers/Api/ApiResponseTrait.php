<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function ApiResponse($data= "",$message = "",$status = ""){

        $array = [
            'Data'=>$data,
            'Message'=>$message,
            'Status'=>$status,
        ];

        return response($array,$status);

    }
}

/*

trait GeneralTrait{

	public function getCurrentLang(){
		return app()->getLocale();

	}End Method

	public function returnError($errNum, $msg){
		return response()->json([
		'status'=>false,
		'errNum'=>$errNum,
		'msg'=>$msg

		]);

	}End Method

	public function returnSuccessMessage($msg = "",$errNum = "S000"){
		return response()->json([
		'status'=>true,
		'errNum'=>$errNum,
		'msg'=>$msg

		]);

	}End Method

	public function returnData($key, $value, $msg = ""){
		return response()->json([
		'status'=>true,
		'errNum'=>"S000",
		'msg'=>$msg,
		$key=> $value

		]);

	}End Method
}

*/

