<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    // use this if u use mass assignment like create(), update() to modify data in db,
    // u need to mention the column that u want to use mass assinment
    protected $fillable = ['title', 'description', 'long_description'];

    public function toggleCompleted() {
        $this->completed = !$this->completed;
        $this->save();
    }
}