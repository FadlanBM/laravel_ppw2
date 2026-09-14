<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MencobaController extends Controller
{
    public function boomesport()
    {
        $data = [
            'title' => 'Boom Esports',
            'description' => 'Ini adalah halaman contoh yang telah disempurnakan untuk latihan routing, controller, dan view (blade) pada Laravel.',
            'players' => ['Fbz', 'Boboka', 'Xnova', 'Ghost', 'NothingToSay']
        ];
        return view('boom', compact('data'));
    }
}
