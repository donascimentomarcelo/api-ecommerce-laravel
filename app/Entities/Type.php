<?php

namespace App\Entities;

use App\Entities\Category;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Type.
 *
 * @package namespace App\Entities;
 */
class Type extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status'
    ];

    public function transform()
    {
        return [
            'name' => $this->name,
            'status' => $this->status
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_types');
    }

}
