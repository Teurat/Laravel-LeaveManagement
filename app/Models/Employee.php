<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    protected $fillable = ['Name', 'company_id', 'EmployedInCompany', 'AnnualLeaveDays', 'LeaveDaysLeft'];

    protected $casts = [
        'EmployedInCompany' => 'date',
        'AnnualLeaveDays' => 'integer',
        'LeaveDaysLeft' => 'integer',
    ];

}
