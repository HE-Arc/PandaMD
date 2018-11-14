<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wait_process extends Model
{
    protected $table = "wait_processes";
    protected $fillable = ['file_id', 'token', 'status', 'error_message'];
}
