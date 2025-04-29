<?php 

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class Valids
 *
 * Métodos utilitários para validações e exceções personalizadas.
 *
 * @method static void CheckIfEntityExists($obj, string $message = "Entity not found", int $status = 404)
 * @method static void CheckIfIdExists($id, string $message = "Id is required", int $status = 400)
 * @method static void ResponseException(string $message = "Internal server error", string $description = "No description", int $status = 500)
 */
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

    public static function ResponseException(
            $message = "Internal server error",
            $description = "No description",
            $status = 500
        )
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
