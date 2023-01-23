<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => $this->created_at,
            'author' => $this->author,
            'writer' => $this->whenLoaded('writer'),
            'comments' => $this->whenLoaded('comments')->each(function ($comment){
                $comment->commentator;
                return $comment;
            }),
            'comment_total' => $this->whenLoaded('comments', function (){
                return count($this->comments);
            })
        ];
    }
}
