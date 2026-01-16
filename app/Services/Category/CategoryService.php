<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repository\Category\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update(Category $category, array $data)
    {
        return $this->categoryRepository->update($category, $data);
    }

    public function delete(Category $category)
    {
        if ($this->categoryRepository->hasProducts($category)) {
            return false;
        }

        return $this->categoryRepository->delete($category);
    }
}