<?php

namespace App\Http\DAO;

use App\Models\Category;

class CategoryDAO
{
    
    public function getAllCategories()
    {
        return Category::query()->orderByDesc('created_at')->paginate(15);
    }

}