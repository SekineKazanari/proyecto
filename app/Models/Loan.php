<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'date_loan',
        'date_return',
        'state'
    ];
    public function users(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function books()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }
}
