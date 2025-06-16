<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThongKeBieuDoController extends Controller
{
    public function dataCollectionGame()
    {
        return view('games.lop4.thong_ke_bieu_do.data_collection');
    }

    public function barChartGame()
    {
        return view('games.lop4.thong_ke_bieu_do.bar_chart');
    }

    public function lineChartGame()
    {
        return view('games.lop4.thong_ke_bieu_do.line_chart');
    }

    public function pieChartGame()
    {
        return view('games.lop4.thong_ke_bieu_do.pie_chart');
    }
} 