<?php

namespace App\Http\Controllers;

use App\Helpers\Valids;
use App\Models\TaskModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private function getTask(int $id)
    {
        try 
        {
            return TaskModel::find($id);
        } 
        catch (\Throwable $th) 
        {
            Valids::ResponseException("Error fetching task", $th, 500);
        }
    }

    public function getAllTasksOfUser()
    {
        try 
        {
            $tasks = TaskModel::where("user_id", session("id"))->paginate(20);
            return response()->json($tasks, 200);
        } 
        catch (\Throwable $th) 
        {
            Valids::ResponseException("Error fetching tasks", $th, 500);
        }
    }

    public function createTask(Request $r)
    {
        try 
        {
            DB::beginTransaction();

            $data = $r->only(['title', 'description']);
            $data['done'] = false;
            $data['user_id'] = session('id');

            TaskModel::create($data);

            DB::commit();
            return response()->json("Task created successfully!", 201);
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            Valids::ResponseException("Error creating task", $th, 500);
        }
    }

    public function updateTask(Request $r, string $id)
    {
        try 
        {
            $id = (int) $id;
            DB::beginTransaction();

            Valids::CheckIfIdExists($id);

            $data = $r->all();
            $task = $this->getTask($id);
            Valids::CheckIfEntityExists($task, "Task not found");

            $task->update($data);

            DB::commit();
            return response()->json("Task updated successfully!", 200);
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            Valids::ResponseException("Error updating task", $th, 500);
        }
    }

    public function deleteTask(string $id)
    {
        try 
        {
            $id = (int) $id;
            DB::beginTransaction();

            Valids::CheckIfIdExists($id);

            $task = $this->getTask($id);
            Valids::CheckIfEntityExists($task, "Task not found");

            if ($task->user_id != session("id")) 
            {
                throw new HttpResponseException(response()->json(
                    ['error' => 'This task does not belong to you.'],
                    403
                ));
            }

            $task->delete();

            DB::commit();
            return response()->json("Task deleted successfully!", 200);
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            Valids::ResponseException("Error deleting task", $th, 500);
        }
    }

    public function changeStatus(string $id)
    {
        try 
        {
            $id = (int) $id;
            DB::beginTransaction();

            Valids::CheckIfIdExists($id);

            $task = $this->getTask($id);
            Valids::CheckIfEntityExists($task, "Task not found");

            if ($task->user_id != session("id")) 
            {
                throw new HttpResponseException(response()->json(
                    ['error' => 'This task does not belong to you.'],
                    403
                ));
            }

            $task->done = !$task->done;
            $task->update(['done' => $task->done]);

            DB::commit();
            return response()->json(
                [
                    "message" => "Task status updated successfully!",
                    'status' => $task->done
                ],
                200
            );
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            Valids::ResponseException("Error updating task status", $th, 500);
        }
    }
}