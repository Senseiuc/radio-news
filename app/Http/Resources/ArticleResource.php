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
        $img = $this->image_url;
        if ($img && !preg_match('/^https?:\/\//i', $img)) {
            $img = asset(ltrim($img, '/'));
        }

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'excerpt'      => str(strip_tags($this->body))->limit(150),
            'image_url'    => $img,
            'video_url'    => $this->video_url,
            'published_at' => optional($this->published_at)->toDateTimeString(),
            'categories'   => $this->whenLoaded('categories', fn () => $this->categories->map(fn ($cat) => [
                'name'  => $cat->name,
                'color' => $cat->color,
                'slug'  => $cat->slug,
            ])),
            'author'       => $this->whenLoaded('author', fn () => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
            ]),
        ];
    }
}
