<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota;

class MascotaController extends Controller
{

    public function index()
    {
        $header = apache_request_headers();
        $rol = $header['role'];
        $id = $header['user_id'];
        return Mascota::where('user_id', $id)->select('id', 'name', 'birthday', 'phone')->get();
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
