<?php

namespace App\Http\Controllers\BackCtrl;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('back-page.categories.index', [
            'title' => 'Kategori',
            'notifications' => $notifications,
        ]);
    }

    /**
     * dataTable
     *
     * @param  Illuminate\Http\Request  $request
     * @return void
     */
    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select('id', 'category_name')->withCount('posts')
                ->orderByDesc('id')->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    if ($row->posts_count <= 0) {
                        return "<input type='checkbox' name='category_checkbox' data-id='$row->id'>";
                    }
                })
                ->addColumn('action', function ($row) {
                    return <<<BTN_ACTION
                        <button type='button' name='edit' id='$row->id' class='category-edit btn btn-sm fa fa-edit bg-warning text-white mr-1'></button>
                        <button type='button' name='delete' id='$row->id' data-delete='$row->category_name' class='category-delete btn btn-sm fa fa-trash-alt bg-danger text-white'></button>
                    BTN_ACTION;
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (request()->ajax()) {
            $category = Category::create([
                'category_name' => Str::title($request['category_name']),
                'slug' => Str::slug($request['category_name']),
            ]);

            return response()->json([
                'success' => 'Berhasil menambah Kategori ' . $category->category_name
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (request()->ajax()) {
            $data = $category->select('id', 'category_name')->whereId($category->id)->first();

            return response()->json([
                'category' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if (request()->ajax()) {
            $categoryNameReq = Str::title($request['category_name']);

            $category->update([
                'category_name' => $categoryNameReq
            ]);

            return response()->json([
                'success' => 'Berhasil merubah data Kategori ' . $categoryNameReq
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (request()->ajax()) {
            try {
                $category->delete();
            } catch (\Exception $ex) {
                return response()->json(
                    ['error' => "Error: Kategori $category->category_name mempunyai Post"],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            return response()->json([
                'success' => 'Berhasil menghapus kategori ' . $category->category_name
            ]);
        }
    }

    /**
     * destroyAllSelected
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function destroyAllSelected(Request $request)
    {
        if ($request->ajax()) {
            $categoryIds = $request->category_ids;

            Category::withCount('posts')->whereIn('id', $categoryIds)->get()->map(function ($category) {
                if ($category->posts_count <= 0) {
                    $category->delete();
                }
            });

            return response()->json([
                'success' => 'Berhasil menghapus semua Kategori yang di pilih',
            ]);
        }
    }
}
