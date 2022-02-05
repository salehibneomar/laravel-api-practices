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
        $student = Auth::guard('jwt')->user();
        if(!($student instanceof Student)){
            return $this->errorResponse('Not available at the moment', 404);
        }
        return $this->singleResponse($student);
    }

    public function update(Request $request, $id)
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

        $token = Auth::guard('jwt')
                ->attempt([
                    'email' => $request->email, 
                    'password' => $request->password
                ]);
        
        if(!$token){
            return $this->errorResponse('Invalid Cr.', 404);
        } 
        
        return $this->successResponse($token, 200);

    }

    public function logout(Request $request){
        Auth::guard('jwt')->logout();
        return $this->successResponse('Logged out successfully!', 200);
    }

}
