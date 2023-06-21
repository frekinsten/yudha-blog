<?php

namespace App\Http\Controllers\BackCtrl;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $userRole = auth()->user()->getRoleNames()->first();

        switch ($userRole) {
            case 'Writer':
            case 'User':
                $totalUser = User::whereId(auth()->user()->id)->count();
                $totalPost = Post::where('user_id', auth()->user()->id)->count();
                break;
            default:
                $totalUser = User::count();
                $totalPost = Post::count();
                break;
        }

        $notifications = auth()->user()->unreadNotifications;
        $totalCategory = Category::count();
        $totalTag = Tag::count();

        return view('back-page.index', [
            'title'         => 'Dashboard',
            'totalUser'     => $totalUser,
            'totalCategory' => $totalCategory,
            'totalTag'      => $totalTag,
            'totalPost'     => $totalPost,
            'notifications' => $notifications,
        ]);
    }
}
