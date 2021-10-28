<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'gender', 'salary'];

    const GENDER_TYPES = [
        0 => 'Не указан',
        1 => 'Женский',
        2 => 'Мужской',
    ];

    public function getFullNameAttribute($value)
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    public function getTextGenderAttribute($value)
    {
        return Employee::GENDER_TYPES[intval($this->gender)];
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'employee_department',
            'employee_id', 'department_id');
    }
}
