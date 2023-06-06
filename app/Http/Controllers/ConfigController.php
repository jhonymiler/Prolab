<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function set_skin(Request $request): void
    {
        $userId = Auth::user()->id;
        if (Cache::has($userId . '.custom')) {
            $dadosCache = Cache::get($userId . '.custom');
            foreach ($request->toArray() as $config => $value) {
                $dadosCache[$config] = $value;
            }
            Cache::forever($userId . '.custom', $dadosCache);
        } else {
            Cache::forever($userId . '.custom', $request->toArray());
        }
    }
}
