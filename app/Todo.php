<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table='todos';
    protected $fillable=['task','status'];
    public function getCreatedAttribute()
    {
        return $this->created_at->DiffForHumans();

    }
}
