<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class BlogPostRepository
 * @package App\Repositories
 */
class BlogPostRepository extends CoreRepository
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }
    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        return $this->startConditions()
                    ->select($columns)
                    ->orderBy('id', 'DESC')
                    ->with([
                        //можно так
                        'category' => function ($query){
                            $query->select(['id', 'title']);
                        },
                        // или так
                        'user:id,name',
                        ])
                    ->paginate(25);
    }

    /** Получить модель для редактирования в админке
     * @param $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}

