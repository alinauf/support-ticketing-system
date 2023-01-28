<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function replies()
    {
        $this->hasMany(TicketReply::class);
    }

}
