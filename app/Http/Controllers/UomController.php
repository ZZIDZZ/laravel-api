<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $uoms = Uom::all();
        return $uoms;
    }
    public function store()
    {
        $uom = new Uom();
        $uom->uom_code = request("uom_code", "");
        $uom->uom_name = request("uom_name", "");
        $uom->save();
        return $uom;
    }
    public function update($id)
    {
        $uom = Uom::find($id); // select * from where id = ? 
        $uom->uom_code = request("uom_code", "");
        $uom->uom_name = request("uom_name", "");
        $uom->save();
        return $uom;
    }
    public function delete($id)
    {
        $uom = Uom::find($id); // select * from where id = ? 
        $uom->delete();
        return[
            "msg" => "uom deleted succesfully"
        ];
    }
}
