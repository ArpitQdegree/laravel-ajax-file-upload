<?php

namespace App\Http\Controllers;

use App\Models\document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class FileController extends Controller
{
    //

    public function index(){
        return view('file');
        // return view('ajax_upload');
    }

    public function store(Request $request){
         $validation = Validator::make($request->all(), ['select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
        if($validation->passes())
        {
            $image = $request->file('select_file');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);

            $doc = new document();
            $doc->title = $new_name;
            $doc->save();

            return response()->json([
            'message'   => 'Image Upload Successfully',
            'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
            'class_name'  => 'alert-success'
            ]);
        }
        else
     {
      return response()->json([
       'message'   => $validation->errors()->all(),
       'uploaded_image' => '',
       'class_name'  => 'alert-danger'
      ]);
     }
    }
}
