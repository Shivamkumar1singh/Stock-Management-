<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Category\CategoryService;
use App\DataTables\CategoryDataTable;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('category.index');
    }

    public function datatable(Request $request, CategoryDataTable $dataTable)
    {
        return $dataTable->make($request);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->store($request->validated());

        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request,Category $category)
    {
        //dd('update hit');
        $this->categoryService->update($category, $request->validated());

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    } 

    public function destroy(Category $category)
    {
        $deleted = $this->categoryService->delete($category);

        if(! $deleted)
        {
            return redirect()->route('category.index')->with('error', 'Cannot delete category because products exists.');            
        }

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
