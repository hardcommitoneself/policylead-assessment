<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * fillable
     */
    protected $fillable = [
        'uuid',
        'title',
        'link',
        'date',
        'excerpt',
        'image'
    ];

    /**
     * nullalbe
     */
    protected $nullable = [
        'excerpt',
        'image'
    ];
}
