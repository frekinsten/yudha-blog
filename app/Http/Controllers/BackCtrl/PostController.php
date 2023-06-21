<?php

namespace App\Http\Controllers\BackCtrl;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    protected $notifications;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->notifications = auth()->user()->unreadNotifications;

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-page.posts.index', [
            'title' => 'Post',
            'notifications' => $this->notifications,
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
            $userRole = auth()->user()->getRoleNames()->first();

            switch ($userRole) {
                case 'Writer':
                    $posts = Post::select('id', 'title', 'slug', 'category_id', 'user_id')
                        ->with(['category:id,category_name', 'tags:id,tag_name', 'user:id,name'])
                        ->where('user_id', auth()->user()->id)
                        ->orderByDesc('id')->get();
                    break;
                default:
                    $posts = Post::select('id', 'title', 'slug', 'category_id', 'user_id')
                        ->with(['category:id,category_name', 'tags:id,tag_name', 'user:id,name'])
                        ->orderByDesc('id')->get();
                    break;
            }

            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn(
                    'checkbox',
                    fn ($row) =>
                    "<input type='checkbox' name='post_checkbox' data-id='$row->id'>"
                )
                ->addColumn(
                    'tags',
                    fn ($row) =>
                    $row->tags->map(
                        fn ($tag) => "<span class='badge badge-default mr-1 my-1'>$tag->tag_name</span>"
                    )->implode('')
                )
                ->addColumn('action', function ($row) {
                    return <<<BTN_ACTION
                        <a href='/master-data/posts/{$row->slug}/edit' class='btn btn-sm fa fa-edit bg-warning text-white text-white mr-1'></a>
                        <button type='button' name='delete' data-slug='$row->slug' data-delete='$row->title' class='post-delete btn btn-sm fa fa-trash-alt bg-danger text-white'></button>
                    BTN_ACTION;
                })
                ->rawColumns(['checkbox', 'tags', 'action'])
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
        $categories = Category::get();
        $tags       = Tag::get();

        return view('back-page.posts.create', [
            'title'         => 'Post',
            'notifications' => $this->notifications,
            'categories'    => $categories,
            'tags'          => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if ($request->hasFile('img_cover')) {
            $file = $request->file('img_cover');

            $path = 'storage/image-cover/';

            $destCoverPath = public_path($path);
            $imgCoverName = time() . '_' . $file->getClientOriginalName();

            Image::make($file)
                ->encode(pathinfo($imgCoverName, PATHINFO_EXTENSION), 100)
                ->resize(1098, 500)
                ->save($destCoverPath . $imgCoverName);
        }

        $slug = SlugService::createSlug(Post::class, 'slug', $request['title']);

        $post = Post::create([
            'title'         => Str::title($request['title']),
            'slug'          => $slug,
            'desc'          => $request['description'],
            'img_cover'     => $imgCoverName,
            'category_id'   => $request['category_id'],
            'user_id'       => auth()->user()->id,
        ]);

        $tags = Tag::whereIn('id', $request['tag_ids'])->get(['id']);
        $post->tags()->attach($tags);

        return redirect()->to('master-data/posts')
            ->with('success', 'Berhasil menambah Post');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::get();
        $tags       = Tag::get();
        $data       = $post->select('id', 'title', 'slug', 'img_cover', 'desc', 'category_id')
            ->with(['category:id,category_name', 'tags:id,tag_name'])
            ->whereSlug($post->slug)->first();

        return view('back-page.posts.edit', [
            'title'         => 'Post',
            'notifications' => $this->notifications,
            'categories'    => $categories,
            'tags'          => $tags,
            'post'          => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if ($request->hasFile('img_cover')) {
            $file = $request->file('img_cover');

            $path = 'storage/image-cover/';

            if (File::exists($path . $post->img_cover)) {
                File::delete($path . $post->img_cover);
            }

            $destCoverPath = public_path($path);
            $newImgCoverName = time() . '_' . $file->getClientOriginalName();

            Image::make($file)
                ->encode(pathinfo($newImgCoverName, PATHINFO_EXTENSION), 100)
                ->resize(1098, 500)
                ->save($destCoverPath . $newImgCoverName);
        }

        $slug = SlugService::createSlug(Post::class, 'slug', $request['title']);

        $post->update([
            'title'         => Str::title($request['title']),
            'slug'          => $slug ?? $post->slug,
            'desc'          => $request['description'] ?? $post->desc,
            'img_cover'     => $newImgCoverName ?? $post->img_cover,
            'category_id'   => $request['category_id'] ?? $post->category->id,
            'user_id'       => auth()->user()->id,
        ]);

        $post->tags()->sync($request['tag_ids']);

        return redirect()->to('master-data/posts')
            ->with('success', 'Berhasil mengubah data Post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (File::exists("storage/images/cover/$post->img_cover")) {
            File::delete("storage/images/cover/$post->img_cover");
        }

        if (File::exists("storage/images/description/$post->img_desc")) {
            File::delete("storage/images/description/$post->img_desc");
        }

        $post->tags()->detach();
        $post->delete();

        return response()->json([
            'success' => 'Berhasil dihapus'
        ]);
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
            $postIds = $request->post_ids;
            Post::with(['tags'])->whereIn('id', $postIds)->get()
                ->map(function ($post) {
                    if (File::exists("storage/images/cover/$post->img_cover")) {
                        File::delete("storage/images/cover/$post->img_cover");
                    }

                    if (File::exists("storage/images/description/$post->img_desc")) {
                        File::delete("storage/images/description/$post->img_desc");
                    }

                    $post->tags()->detach();
                    $post->delete();
                });

            return response()->json([
                'success' => 'Berhasil menghapus semua Post yang di pilih',
            ]);
        }
    }
}
