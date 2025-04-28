<?php 

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

class Valids 
{
    public static function CheckIfEntityExists($obj, $message = "Entity not found", $status = 404)
    {
        if (!$obj)
        {
            throw new HttpResponseException(response()->json(
                ['error' => $message],
                $status
            ));
        }
    }

    public static function CheckIfIdExists($id, $message = "Id is required", $status = 400)
    {
        if (!$id)
        {
            throw new HttpResponseException(response()->json(
                ['error' => $message],
                $status
            ));
        }
    }

    public static function ResponseException($message = "Internal server error", $description ,$status = 500)
    {
        throw new HttpResponseException(response()->json(
            [
                'error' => $message,
                'description' => $description
            ],
            $status
        ));
    }
}
