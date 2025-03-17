<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeteranganLulus;

class KeteranganLulusController extends Controller
{
    public function index()
    {
        $keteranganLulus = KeteranganLulus::all();
        return view('admin.keteranganLulus', compact('keteranganLulus'));
    }
}
