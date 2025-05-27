<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'visit_date',
        'visit_room',
        'visit_note',
    ];

    protected $dates = ['visit_date'];

    public function patient() {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
