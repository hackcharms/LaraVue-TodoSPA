<?php
namespace App\Http\Helpers;

trait Helper{

    // public static function ApiResponse($data,$status)
    // {
    //     $respose=response(["status"=>$status,"data"=>$data])
    //     ->withHeaders([
    //         'Content-Type' => 'application/json',
    //     ])
    //     ;
    //     return $respose;

    // }
    public static function ApiResponse(int $status=404,string $message='Data Not Found',object $data=null):object
    {
        $respose=response(["status"=>$status,"message"=>$message,"data"=>$data])
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ;
        return $respose;

    }
}
