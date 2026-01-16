<?php

namespace App\DataTables;
use Carbon\Carbon;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryDataTable
{
    public function make($request)
    {
        $query = Category::select([
            'id',
            'name',
            'created_at'
        ]);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($category) {
                return $category->created_at
                    ? Carbon::parse($category->created_at)->format('d-m-Y')
                    : '-';
            })
            ->addColumn('actions', function ($category) {
                return '
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="'.route('category.edit', $category).'" class="btn btn-sm btn-warning px-3">Edit</a>
                        <form method="POST"  action="'.route('category.destroy', $category->id).'" style="display:inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger px-3" onclick="return confirm(\'Delet this category?\')"> Delete</button>
                        </form>
                    </div>
                    ';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }
}