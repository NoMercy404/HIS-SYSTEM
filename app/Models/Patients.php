<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Patients extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PatientsFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'PESEL',
        'DateOfBirth',
        'phoneNumber',
        'adress',
        'is_on_ward',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }
    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class, 'patient_id');
    }
    public function researches()
    {
        return $this->hasMany(Research::class); // lub 'App\Models\Research' jeśli nie masz use na górze
    }

}
