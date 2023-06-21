<?php

namespace App\Http\Controllers\BackCtrl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotificationCollection;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            auth()->user()
                ->unreadNotifications
                ->when($request->id, function (DatabaseNotificationCollection $query) use ($request) {
                    return $query->where('id', '=', $request->id);
                })
                ->markAsRead();
        }

        return response()->noContent();
    }
}
