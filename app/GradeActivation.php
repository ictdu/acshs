<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeActivation extends Model
{
    protected $table = 'grade_activation';

    protected $fillable = [
        'status',
    ];
}
