<?php

namespace App\Http\Controllers\BackCtrl;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        return view('back-page.tags.index', [
            'title' => 'Tag',
            'notifications' => $notifications,
        ]);
    }

    /**
     * dataTable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $tags = Tag::select('id', 'tag_name')->withCount('posts')->orderByDesc('id')->get();

            return DataTables::of($tags)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    if ($row->posts_count <= 0) {
                        return "<input type='checkbox' name='tag_checkbox' data-id='$row->id'>";
                    }
                })
                ->addColumn('action', function ($row) {
                    return <<<BTN_ACTION
                        <button type='button' name='edit' id='$row->id' class='tag-edit btn btn-sm fa fa-edit bg-warning text-white mr-1'></button>
                        <button type='button' name='delete' id='$row->id' data-delete='$row->tag_name' class='tag-delete btn btn-sm fa fa-trash-alt bg-danger text-white'></button>
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
     * @param  \App\Http\Requests\TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        if (request()->ajax()) {
            $tag = Tag::create([
                'tag_name' => Str::title($request['tag_name']),
                'slug' => Str::title($request['tag_name'])
            ]);

            return response()->json([
                'success' => 'Berhasil menambah Tag ' . $tag->tag_name
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        if (request()->ajax()) {
            $data = $tag->select('id', 'tag_name')->whereId($tag->id)->first();

            return response()->json([
                'tag' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        if (request()->ajax()) {
            $tagNameReq = Str::title($request['tag_name']);

            $tag->update([
                'tag_name' => $tagNameReq
            ]);

            return response()->json([
                'success' => 'Berhasil merubah data Tag ' . $tagNameReq
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (request()->ajax()) {
            try {
                $tag->delete();
            } catch (\Exception $ex) {
                return response()->json(
                    ['error' => "Error: Tag $tag->tag_name mempunyai Post"],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            return response()->json([
                'success' => "Berhasil menghapus Tag $tag->tag_name"
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
            $tagIds = $request->tag_ids;

            Tag::withCount('posts')->whereIn('id', $tagIds)->get()->map(function ($tag) {
                if ($tag->posts_count <= 0) {
                    $tag->delete();
                }
            });

            return response()->json([
                'success' => 'Berhasil menghapus semua Tag yang di pilih',
            ]);
        }
    }
}
