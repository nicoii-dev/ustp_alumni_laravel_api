<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Training;
use App\Models\JobHistory;
use App\Models\Employment;
use App\Models\Address;
use App\Models\Education;
use App\Models\Achivement;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumni_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'civil_status',
        'phone_number',
        'dob',
        'role',
        'status',
        'email',
        'password',
        'image'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function trainings() {
        return $this->hasMany(Training::class, 'user_id', 'id');
    }

    public function jobHistory() {
        return $this->hasMany(JobHistory::class, 'user_id', 'id');
    }

    public function employment() {
        return $this->hasOne(Employment::class, 'user_id', 'id');
    }

    public function address() {
        return $this->hasOne(Address::class, 'user_id', 'id');
    }

    public function education() {
        return $this->hasOne(Education::class, 'user_id', 'id');
    }

    public function achievements() {
        return $this->hasMany(Achivement::class, 'user_id', 'id');
    }
}
