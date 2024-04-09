<?php

namespace App\Http\Controllers;

class KetuaBidang extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
            return view('/tugasakhir/layouts/content');
    }

    public function penentuan_bidang(){
        return view('tugasakhir.ketuabidang.penentuan_bidang');
    }
}
