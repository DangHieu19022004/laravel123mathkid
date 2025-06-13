<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThuThachDoLuongController extends Controller
{
    public function lengthMeasurementGame()
    {
        return view('games.lop4.thu_thach_do_luong.length_measurement');
    }

    public function weightMeasurementGame()
    {
        return view('games.lop4.thu_thach_do_luong.weight_measurement');
    }

    public function timeMeasurementGame()
    {
        return view('games.lop4.thu_thach_do_luong.time_measurement');
    }

    public function moneyCalculationGame()
    {
        return view('games.lop4.thu_thach_do_luong.money_calculation');
    }
} 