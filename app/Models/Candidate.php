<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['job_id','name', 'email', 'phone', 'year', 'created_by', 'updated_by', 'deleted_by'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
   
}
