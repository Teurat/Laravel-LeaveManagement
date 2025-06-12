<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function leavetype()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
    protected $fillable = ['employee_id', 'leave_type_id', 'DateFrom', 'DateTo', 'LeaveDays', 'isApproved'];

    protected $casts = [
        'DateFrom' => 'date',
        'DateTo' => 'date',
    ];
}
