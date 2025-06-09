<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);
        $user->unreadNotifications->markAsRead(); // Marquer toutes les notifications comme lues
        return view('notifications.index', compact('notifications'));
    }
}