<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 * @package App\Models
 *
 * @property-read BlogCategory  $parentCategory
 * @property-read string        $parentTitle
 */
class BlogCategory extends Model
{
    use SoftDeletes;

    protected $fillable
    = [
            'title',
            'slug',
            'parent_id',
            'description',
        ];
    //private $parent_id;
    const ROOT = 1;

    /** Получить родительскую категорию
     * @return BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /** Пример аксессуара (Accessor)
     * @url https://laravel.com/docs/5.8/eloquent-mutators
     * @return BelongsTo
     */
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корень'
                : '???');
        return $title;
    }
    /**
     * Является ли текущий объект корневым
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }
}
