<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model {

    use HasFactory;

    public function children() {
        return $this->hasMany(Tree::class, 'parent_id', 'id');
    }

}
