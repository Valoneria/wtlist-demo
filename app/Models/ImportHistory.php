<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{

    use HasFactory;
    protected $table = 'import_histories';
    protected $fillable = [
        "timestamp",
        "status",
        "imported",
        "skipped",
        "failed"
    ];
}
