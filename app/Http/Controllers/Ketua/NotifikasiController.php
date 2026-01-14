<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penarikan;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function countPending()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $user = Auth::user();

        $jumlah = Penarikan::where('status', 'pending')
            ->whereHas('warga', function ($q) use ($user) {
                $q->where('desa_id', $user->desa_id)
                  ->where(function($sub) use ($user) {
                      $sub->where('rw', $user->rw)
                          ->orWhere('rw', (int)$user->rw)
                          ->orWhere('rw', str_pad($user->rw, 2, '0', STR_PAD_LEFT));
                  });
            })->count();

        return response()->json(['count' => $jumlah]);
    }
}