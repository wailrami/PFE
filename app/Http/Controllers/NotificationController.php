<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = Notification::find($id);
        $notification->markAsRead();
        if($notification->type == 'reservation_client')
        {
            return redirect()->route('reservations.index');
        }
        else if($notification->type == 'reservation_gestionnaire')
        {
            return redirect()->route('gestionnaire.reservations.requests');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
        $notification->delete();
        return redirect()->route('notifications');
    }

    /**
     * Mark the notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->markAsRead();

        return redirect()->route('notifications');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $notifications = auth()->user()->notifications;
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->route('notifications');
    }

    /**
     * Mark the notification as unread
     */

    public function markAsUnread($id)
    {
        $notification = Notification::find($id);
        $notification->markAsUnread();

        return redirect()->route('notifications');
    }

}
