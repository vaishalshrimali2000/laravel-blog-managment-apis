<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $likedByUser = $user ? $this->likes->contains('user_id',$user->id) : false;

        return [
            'id' => $this->id,
            'author' => [
                'id' => $this->user_id,
                'name' => $this->whenLoaded('user',fn()=>$this->user->name)
            ],
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_path ? asset('storage/'.$this->image_path) : null,
            'likes_count' => $this->likes_count ?? $this->likes()->count(),
            'like_by_me' => $likedByUser,
            'created_at' => $this->created_at,
        ];
    }
}
