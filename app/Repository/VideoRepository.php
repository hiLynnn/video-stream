<?php
namespace App\Repository;

use App\ComboVideo;
use App\Movies;

class VideoRepository extends BaseRepository {
    public function getCursorBy($except, $limit = 10){
        $model = $this->model->query();
        $model->orderBy('updated_at', 'DESC');
        $model->whereNotIn('id', [$except]);

        return $model->cursorPaginate($limit);
    }
}
