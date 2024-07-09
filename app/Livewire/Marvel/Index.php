<?php

namespace App\Livewire\Marvel;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        $peticion = Http::get('https://gateway.marvel.com:443/v1/public/characters?ts=1&apikey=c6c83b8727de448358ba3f29737d1a84&hash=8452977857c8e9900a153a8354de2204');
        $data = $peticion->json();
        $heroes = $data['data']['results'];

        return view('livewire.marvel.index', compact('heroes'));
    }
}
