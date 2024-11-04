<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboVideo extends Model
{
    use HasFactory;

    // Specify the table name (optional if it matches the model name)
    protected $table = 'combo_video';

    // Define which columns can be mass-assigned
    protected $fillable = [
        'timestamp',
        'ref_id',
        'model',
    ];

    // Specify the primary key (optional if it's 'id')
    protected $primaryKey = 'id';

    // Disable auto-incrementing if 'id' is not an auto-incrementing key
    public $incrementing = true;

    // Set the primary key type (if it's not an integer)
    protected $keyType = 'int';

    // Automatically manage the `created_at` and `updated_at` timestamps
    public $timestamps = true;

    // Add any relationships or custom methods below
}
