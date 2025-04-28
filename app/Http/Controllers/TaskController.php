<?php

namespace App\Http\Controllers;

use App\Helpers\Valids;
use App\Models\TaskModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAllTasksOfUser()
    {
        try
        {
            $tasks = TaskModel::where("user_id",session("id"))->get();

            return response()->json($tasks, 200);
        }
        catch (\Throwable $th) 
        {
            Valids::ResponseException("Error fetching tasks", $th, 500);
        }
    }
}
