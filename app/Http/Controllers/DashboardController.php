<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KeteranganAktif;
use App\Models\KeteranganLulus;
use App\Models\LaporanHasilStudi;
use App\Models\PengantarMataKuliah;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $keteranganAktifCount = KeteranganAktif::count();
        $keteranganLulusCount = KeteranganLulus::count();
        $laporanHasilStudiCount = LaporanHasilStudi::count();
        $pengantarMataKuliahCount = PengantarMataKuliah::count();

        // Data untuk Pie Chart
        $chartData = [
            'labels' => ['Keterangan Aktif', 'Keterangan Lulus', 'Laporan Hasil Studi', 'Pengantar Mata Kuliah'],
            'data' => [$keteranganAktifCount, $keteranganLulusCount, $laporanHasilStudiCount, $pengantarMataKuliahCount],
            'colors' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
        ];

        // Monthly data for Area Chart
        $monthlyData = [
            'labels' => [],
            'keteranganAktif' => [],
            'keteranganLulus' => [],
            'laporanHasilStudi' => [],
            'pengantarMataKuliah' => []
        ];

        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i)->format('M');
            $monthlyData['labels'][] = $month;
            $monthlyData['keteranganAktif'][] = KeteranganAktif::whereMonth('created_at', Carbon::now()->subMonths($i)->month)->count();
            $monthlyData['keteranganLulus'][] = KeteranganLulus::whereMonth('created_at', Carbon::now()->subMonths($i)->month)->count();
            $monthlyData['laporanHasilStudi'][] = LaporanHasilStudi::whereMonth('created_at', Carbon::now()->subMonths($i)->month)->count();
            $monthlyData['pengantarMataKuliah'][] = PengantarMataKuliah::whereMonth('created_at', Carbon::now()->subMonths($i)->month)->count();
        }

        return view('admin.dashboard', compact(
            'userCount', 
            'keteranganAktifCount', 
            'keteranganLulusCount', 
            'laporanHasilStudiCount',
            'pengantarMataKuliahCount',
            'chartData',
            'monthlyData'
        ));
    }
}
