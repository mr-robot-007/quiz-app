<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Institute extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'institutes';

    protected $fillable = [
        'title',
        'person_name',
        'person_contact',
        'address',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
