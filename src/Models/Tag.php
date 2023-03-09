<?php

namespace Uiibevy\UiiTaggable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'name', 'slug' ];

    /**
     * @param string|\Illuminate\Database\Eloquent\Model $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function childrenOf(string|Model $class): MorphToMany
    {
        $class = $class instanceof Model ? $class->getMorphClass() : $class;
        return $this->morphedByMany($class, 'taggable');
    }
}
