<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(10);
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json([
            'message' => 'User update successfully',
            'data' => $user
        ], 201);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 201);
    }

  public function register(Request $request)
  {
      $this->validate($request, [
          'name' => 'required',
          'email' => 'required|unique:users|email',
          'password' => 'required|min:6'
      ]);

      $name = $request->input('name');
      $email = $request->input('email');
      $password = Hash::make($request->input('password'));

      $user = User::create([
          'name' => $name,
          'email' => $email,
          'password' => $password
      ]);

      return response()->json([
        'message' => 'Data added successfully',
        'data' => $user
    ], 201);
  }

  public function login(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|min:6'
      ]);

      $email = $request->input('email');
      $password = $request->input('password');

      $user = User::where('email', $email)->first();
      if (!$user) {
          return response()->json(['message' => 'Login failed'], 401);
      }

      $isValidPassword = Hash::check($password, $user->password);
      if (!$isValidPassword) {
        return response()->json(['message' => 'Login failed'], 401);
      }

      $generateToken = bin2hex(random_bytes(40));
      $user->update([
          'token' => $generateToken
      ]);

      return response()->json($user);
  }



} 