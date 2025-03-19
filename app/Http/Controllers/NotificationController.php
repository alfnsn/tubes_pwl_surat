<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notifikasi::find($id);
        if ($notification) {
            $notification->status = 'read';
            $notification->save();
        }
        return redirect()->back();
    }
}
