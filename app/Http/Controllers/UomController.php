<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UomController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        $uoms = Uom::all();
        return $uoms;
    }
    public function show($id){
        $uom = Uom::find($id);
        if($uom) return $uom;
        else{
            return response()->json([
                'message' => 'uom not found',
            ], 404);
        }
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'uom_code' => 'required|unique:uoms',
            'uom_name' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $uom = new Uom();
        $uom->uom_code = request("uom_code", "");
        $uom->uom_name = request("uom_name", "");
        $uom->save();
        return $uom;
    }
    public function update($id)
    {
        $uom = Uom::find($id); // select * from where id = ? 
        $validator = Validator::make(request()->all(), [
            'uom_code' => 'required|unique:uoms,uom_code,'.$uom->id,
            'uom_name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
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
