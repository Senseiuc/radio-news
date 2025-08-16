<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'excerpt'      => str(strip_tags($this->body))->limit(150),
            'image_url'    => $this->image ? asset("storage/{$this->image}") : null,
            'video_url'    => $this->video_url,
            'published_at' => optional($this->published_at)->toDateTimeString(),
            'categories'   => $this->categories->map(fn ($cat) => [
                'name'  => $cat->name,
                'color' => $cat->color,
                'slug'  => $cat->slug,
            ]),
            'author'       => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
            ],
        ];
    }
}
