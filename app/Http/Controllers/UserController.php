<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $r)
    {
        try {
            DB::beginTransaction();

            $data = $r->only(['name', 'email', 'password']);
            $data['email'] = trim(strtolower($data['email']));
            $data['password'] = Hash::make($data['password']);

            User::create($data);

            $user = $this->findUserByEmail($data['email']);
            $this->isUserNull($user);

            session()->put('id', $user->id);
            session()->put('active', true);
            session()->put('email', $user->email);

            DB::commit();
            return response()->json('User created', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new HttpResponseException(response()->json(
                [
                    'error' => 'Internal Server Error',
                    'description' => $th
                ],
                500
            ));
        }
    }

    public function login(Request $r)
    {
        try 
        {
            $data = $r->only(['email', 'password']);

            $user = $this->findUserByEmail($data['email']);
            if (!$user) 
            {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            if (!Hash::check($data['password'], $user->password)) 
            {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            session()->put('id', $user->id);
            session()->put('active', true);
            session()->put('email', $user->email);

            return response()->json('Logged in successfully', 200);
        } 
        catch (\Throwable $th) 
        {
            throw new HttpResponseException(response()->json(
                ['error' => 'Internal Server Error'],
                500
            ));
        }
    }

    public function logout()
    {
        try 
        {
            session()->flush();
            return response()->json('Logged out successfully', 200);
        } 
        catch (\Throwable $th) 
        {
            throw new HttpResponseException(response()->json(
                ['error' => 'Internal Server Error'],
                500
            ));
        }
    }

    public function get()
    {
        try 
        {
            $user = User::find(session('id'));
            $this->isUserNull($user);

            return response()->json($user, 200);
        } 
        catch (\Throwable $th) 
        {
            throw new HttpResponseException(response()->json(
                ['error' => 'Internal Server Error'],
                500
            ));
        }
    }

    public function update(Request $r)
    {
        try 
        {
            DB::beginTransaction();

            $data = $r->only(['name', 'email', 'password']);
            $user = User::find(session('id'));
            $this->isUserNull($user);

            if (isset($data['email'])) 
            {
                $data['email'] = trim(strtolower($data['email']));
            }

            if (isset($data['password'])) 
            {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);

            DB::commit();
            return response()->json('User updated successfully', 200);
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            throw new HttpResponseException(response()->json(
                ['error' => 'Internal Server Error'],
                500
            ));
        }
    }

    public function delete()
    {
        try 
        {
            DB::beginTransaction();

            $user = User::find(session('id'));
            $this->isUserNull($user);

            $user->forceDelete();

            $this->logout();

            DB::commit();
            return response()->json('User deleted successfully', 200);
        } 
        catch (\Throwable $th) 
        {
            DB::rollBack();
            throw new HttpResponseException(response()->json(
                ['error' => 'Internal Server Error'],
                500
            ));
        }
    }

    private function findUserByEmail(string $email)
    {
        if(!$email)
        {
            throw new HttpResponseException(response()->json(
                ['error' => 'Email is required'],
                404
            ));
        }
        $email = trim(strtolower($email));
        return User::where('email', $email)->first();
    }

    private function isUserNull($user)
    {
        if (!$user) {
            throw new HttpResponseException(response()->json(
                ['error' => 'User not found'],
                404
            ));
        }
    }
}
