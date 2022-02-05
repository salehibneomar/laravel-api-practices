<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends ApiController
{
    public function index()
    {
        //
    }

    public function show()
    {
        // $student = Auth::user();
        // if(!($student instanceof Student)){
        //     return $this->errorResponse('Not available at the moment', 404);
        // }
        // return $this->singleResponse($student);
    }

    public function update(Request $request)
    {
        //
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:60',
            'email' => 'required|email|max:100|unique:students',
            'password' => 'required|min:6|max:32|confirmed',
        ]);

        $student = new Student();
        $student->fill($request->only([
            'name',
            'email',
        ]));

        $student->password = Hash::make($request->password);

        if($student->save()){
            return $this->singleResponse($student, 201);
        }

        return $this->errorResponse('Failed to register', 500);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = Auth::attempt(['email'=>$request->email, 'password'=>$request->password]);

        $accessToken = auth()->user()->createToken('authToken');

        return $accessToken;
    }

    public function logout(Request $request){
        
        return $this->successResponse('Logged out successfully!', 200);
    }
}
