<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotifikasiStatus;

class NotificationController extends Controller
{
    /**
     * Mengambil daftar notifikasi terbaru
     */
    public function getLatest()
    {
        $user = Auth::user();
        $userId = $user->id_user; 
        
        $roleName = $user->role->nama_role ?? ''; 

        $query = Notifikasi::query();

        if (!in_array($roleName, ['admin_pusat', 'admin_data'])) {
            $userDesa = $user->desa->nama_desa ?? ''; 
            $userRW   = $user->rw ?? '';
            $query->where('desa_kegiatan', $userDesa)->where('rw_kegiatan', $userRW);
        }

        $query->whereDoesntHave('statuses', function($q) use ($userId) {
            $q->where('user_id', $userId) 
              ->whereNotNull('deleted_at');
        });

        $notifikasis = $query->latest('created_at')->take(10)->get();

        $formattedData = $notifikasis->map(function($notif) use ($userId) {
            $isRead = $notif->statuses()
                            ->where('user_id', $userId)
                            ->whereNotNull('read_at')
                            ->exists();
            $notif->is_read = $isRead;
            return $notif;
        });

        $allRelevantIds = $query->pluck('id_notif'); 
        $readCount = NotifikasiStatus::whereIn('notifikasi_id', $allRelevantIds)
                        ->where('user_id', $userId) 
                        ->whereNotNull('read_at')
                        ->count();
        
        $unreadCount = $allRelevantIds->count() - $readCount;

        return response()->json([
            'count' => $unreadCount > 0 ? $unreadCount : 0,
            'data' => $formattedData
        ]);
    }

    public function markAsRead(Request $request)
    {
        $notifId = $request->id;
        $user = Auth::user();

        NotifikasiStatus::updateOrCreate(
            [
                'user_id' => $user->id_user,
                'notifikasi_id' => $notifId
            ],
            [
                'read_at' => now()
            ]
        );

        return response()->json(['success' => true]);
    }

    public function deleteForUser(Request $request)
    {
        $notifId = $request->id;
        $user = Auth::user();

        NotifikasiStatus::updateOrCreate(
            [
                'user_id' => $user->id_user,
                'notifikasi_id' => $notifId
            ],
            [
                'deleted_at' => now()
            ]
        );

        return response()->json(['success' => true]);
    }
}