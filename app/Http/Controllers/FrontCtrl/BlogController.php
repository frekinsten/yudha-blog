<?php

namespace App\Http\Controllers\FrontCtrl;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class BlogController extends Controller
{
    private $categories, $tags;

    public function __construct(Category $category, Tag $tag)
    {
        $this->categories = $category->select('id', 'category_name')->orderByDesc('id')->get();
        $this->tags = $tag->select('id', 'tag_name')->orderByDesc('id')->get();
    }

    public function index(Request $request)
    {
        $title = ' ' . config('app.name');

        if ($request->has('category')) {
            $category = Category::firstWhere('slug', $request->category);
            $title = ', Kategori: ' . $category->category_name;
        }

        if ($request->has('tag')) {
            $tag = Tag::firstWhere('slug', $request->tag);
            $title = ', Tag: ' . $tag->tag_name;
        }

        if ($request->has('author')) {
            $author = User::firstWhere('username', $request->author);
            $title = ', By: ' . $author->name;
        }

        $posts = Post::with(['category:id,category_name', 'tags:id,tag_name', 'user:id,name'])
            ->orderByDesc('id')
            ->filter(request(['search', 'category', 'tag', 'author']))
            ->paginate(3)
            ->withQueryString();

        return view('front-page.blogs.index', [
            'title' => 'Semua Posts' . $title,
            'posts' => $posts,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    public function show(Post $post)
    {
        $data = $post->with([
            'user:id,name',
            'tags',
            'comments' => fn ($query) => $query->with([ // lv.1
                'user:id,name',
                'replies' => fn ($query) => $query->with([ // lv.2
                    'user:id,name',
                    'replies' => fn ($query) => $query->with([ // lv.3
                        'user:id,name',
                    ])
                ]),
            ]),
        ])->whereId($post->id)->first();

        $commentsCount = $data->comments->count();
        $commentsCount += $data->comments->pluck('replies')->flatten()->count();
        $commentsCount += $data->comments->pluck('replies.*.replies')->flatten()->count();

        $data->setAttribute('comments_count', $commentsCount);

        return view('front-page.blogs.single', [
            'title' => 'Post Detail',
            'post' => $data,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ]);
    }

    public function storeComment(Request $request)
    {
        $rules = [
            'comment_txt'  => ['required', 'string'],
        ];

        $messages = [
            'required'  => ':attribute tidak boleh kosong',
            'string'    => ':attribute harus bertipe string',
        ];

        $customAttrs = [
            'comment_txt'   => 'Komentar',
        ];

        $validateData = $this->validate($request, $rules, $messages, $customAttrs);

        Comment::create([
            'comment' => $validateData['comment_txt'],
            'post_id' => $request->post_id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function storeReply(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'reply_txt'  => ['required', 'string'],
            ];

            $messages = [
                'required'  => ':attribute tidak boleh kosong',
                'string'    => ':attribute harus bertipe string',
            ];

            $customAttrs = [
                'reply_txt'   => 'Komentar Balasan',
            ];

            $validateData = $this->validate($request, $rules, $messages, $customAttrs);

            Comment::create([
                'comment'   => $validateData['reply_txt'],
                'post_id'   => $request->post_id,
                'user_id'   => auth()->user()->id,
                'parent_id' => $request->comment_id,
            ]);

            return response()->noContent();
        }
    }

    public function deleteComment(Comment $comment)
    {
        if (request()->ajax()) {
            $comment->delete();
            return response()->noContent();
        }
    }
}
