<?php

namespace App\Model;

use Core\Model;

class Post extends Model {
	protected $table = "posts";

	public function list(){
       return $this->select("posts.id,
                                   posts.title,
                                   posts.content,
                                   posts.thumbnail as capa,
                                   posts.status as status,
                                   categories.name as category,
                                   users.name as user,
                                   posts.created_at as criacao")
                    ->join("categories","posts.category_id","categories.id")
                    ->join("users","users.id","posts.user_id")
                    ->busca("title,content,status")
                     ->order("order by posts.id desc")
                    ->paginate(1)
                    ->get();
    }
}