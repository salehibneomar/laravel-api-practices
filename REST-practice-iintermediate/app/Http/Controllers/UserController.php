<?php

namespace App\Http\Controllers;

use App\Mail\UserVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{

    public function index()
    {
        $users = User::all();

        return $this->showAllResponse($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->showSingleResponse($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3|max:50',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User();
        $user->name               = $request->name;
        $user->email              = $request->email;
        $user->password           = Hash::make($request->password);
        $user->type               = User::BUYER;
        $user->verified           = User::UNVERIFIED;
        $user->verification_token = User::generateVerificationCode();

        if($user->save()){
            Mail::to($user->email)->send(new UserVerificationMail($user));
        }

        return $this->showSingleResponse($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'min:3|max:50',
            'email'    => 'email|unique:users,email,'.$id,
            'password' => 'min:6|confirmed',
            'type'     => 'in:admin,buyer,seller',
        ]);

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email!=$request->email){
            $user->verified = User::UNVERIFIED;
            $user->email_verified_at  = null;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = Hash::make($request->password);
        }

        if($user->isClean()){
            return $this->errorResponse('No change', 422);
        }

        if($user->save()){
            if($user->wasChanged('email')){
                Mail::to($user->email)->send(new UserVerificationMail($user));
            }
        }

        return $this->showSingleResponse($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->showSingleResponse($user);
    }

    public function verify($token){
        try{
            $user = User::where('verification_token', $token)->firstOrFail();
            $user->verified = User::VERIFIED;
            $user->verification_token = null;
            $user->email_verified_at = Carbon::now();

            $user->save();
        }
        catch(ModelNotFoundException $e){
            return $this->errorResponse('Invalid verification token', 404);
        }

        return $this->successResponse('User account verified successfully', 200);
    }
}
