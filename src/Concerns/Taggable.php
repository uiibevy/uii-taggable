<?php

namespace Uiibevy\UiiTaggable\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Taggable
{
    /**
     * @param string|array|\Illuminate\Contracts\Support\Arrayable|\Illuminate\Support\Collection $tag
     *
     * @return \Illuminate\Support\Collection
     */
    public function createTag(string|array|Arrayable|Collection $tag): Collection
    {
        if (is_string($tag) || is_array($tag)) {
            $tag = collect($tag);
        }
        if ($tag instanceof Arrayable) {
            $tag = collect($tag->toArray());
        }
        $tag->map(fn($tag) => $this->tags()->create([ 'name' => $tag, 'slug' => $tag ]));
        return $this->tags()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tags(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param string|array|Arrayable|Collection $tag
     *
     * @return Collection
     */
    public function removeTag(string|array|Arrayable|Collection $tag): Collection
    {
        if (is_string($tag) || is_array($tag)) {
            $tag = collect($tag);
        }
        if ($tag instanceof Arrayable) {
            $tag = collect($tag->toArray());
        }
        $tag->map(fn($tag) => $this->tags()->where('name', $tag)->delete());
        return $this->tags()->get();
    }

    /**
     * @param string|array|Arrayable|Collection $tag
     *
     * @return Collection
     */
    public function syncTag(string|array|Arrayable|Collection $tag): Collection
    {
        if (is_string($tag) || is_array($tag)) {
            $tag = collect($tag);
        }
        if ($tag instanceof Arrayable) {
            $tag = collect($tag->toArray());
        }
        $this->tags()->delete();
        $tag->map(fn($tag) => $this->tags()->create([ 'name' => $tag, 'slug' => $tag ]));
        return $this->tags()->get();
    }
}
