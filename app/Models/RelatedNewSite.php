<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedNewSite extends Model
{
    use HasFactory;
    protected $table = 'related_sites';
    protected $fillable = ['name' , 'url'];
}
