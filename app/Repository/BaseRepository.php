<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository {
    public function __construct(protected Model $model)
    {

    }
}
