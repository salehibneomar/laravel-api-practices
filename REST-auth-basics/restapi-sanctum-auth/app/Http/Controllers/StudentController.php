<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
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
        $student = Auth::guard('sanctum')->user();
        if(!($student instanceof Student)){
            return $this->errorResponse('Not available at the moment', 404);
        }
        return $this->singleResponse($student);
    }

    public function update(Request $request)
    {
        //
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:60',
            'email' => 'required|email|max:100|unique:students',
            'phone' => 'required|max:30|unique:students',
            'password' => 'required|min:6|max:32|confirmed',
        ]);

        $student = new Student();
        $student->fill($request->only([
            'name',
            'email',
            'phone',
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

        $student = Student::where('email', $request->email)->withoutTrashed()
        ->first();

        if(is_null($student) || !(Hash::check($request->password, $student->password))){
            return $this->errorResponse('Invalid credentials', 404);
        }
        else{
            $token = $student->createToken('auth_token')->plainTextToken;
            return $token;
        }
        
    }

    public function logout(Request $request){
        Auth::guard('sanctum')->user()->tokens()->delete();
        return $this->successResponse('Logged out successfully!', 200);
    }

}
