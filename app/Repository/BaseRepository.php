<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository {
    public function __construct(protected Model $model)
    {

    }
    public function getCursorBy($conditions = [], $with=[], $select = ['*'], $limit = 10){
        $model = $this->model->query();
        $model->select($select);
        $model->with($with);
        foreach ($conditions as $key => $value) {
            if($key == 'order_by'){
                foreach ($value as $key2 => $value2) {
                    $model->orderBy($value2[0], $value2[1] ?? 'ASC');
                }
            } else if($key == 'except'){
                $model->whereNotIn('id', [$value]);
            }
            else {
                $model->where($key, $value);
            }
        }
        return $model->cursorPaginate($limit);
    }
}
