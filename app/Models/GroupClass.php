<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupClass extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'no_group_member', 'is_member', 'price', 'branch_location'];
}
