<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KeteranganAktif;
use App\Models\KeteranganLulus;
use App\Models\LaporanHasilStudi;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $keteranganAktifCount = KeteranganAktif::count();
        $keteranganLulusCount = KeteranganLulus::count();
        $laporanHasilStudiCount = LaporanHasilStudi::count();

        return view('admin.dashboard', compact('userCount', 'keteranganAktifCount', 'keteranganLulusCount', 'laporanHasilStudiCount'));
    }
}
