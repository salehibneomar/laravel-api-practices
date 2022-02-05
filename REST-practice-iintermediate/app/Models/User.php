<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const VERIFIED   = '1';
    public const UNVERIFIED = '0';
    public const ADMIN      = 'admin';
    public const BUYER      = 'buyer';
    public const SELLER     = 'seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isVerified(){
        return $this->verified == User::VERIFIED;
    }

    public function isAdmin(){
        return $this->type == User::ADMIN;
    }

    public function isBuyer(){
        return $this->type == User::BUYER;
    }

    public function isSeller(){
        return $this->type == User::SELLER;
    }

    public static function generateVerificationCode(){
        return Str::replace('-', '', Str::uuid());
    }

    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
}
