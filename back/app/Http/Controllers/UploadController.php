<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class UploadController extends Controller
{
    public function upload(Request $request){
        $this->validate($request, [
            'file'=>'required',
        ]);
//        if ($request->hasFile('file')) {
//            $file=$request->file('file');
//            $nombreArchivo = time().".".$file->getClientOriginalExtension();
//            $file->move(\public_path('imagenes'), $nombreArchivo);
//        }
        if ($request->hasFile('file')){
            $file    = $request->file('file');
            $nombre     = time().".".$file->getClientOriginalExtension();;
            $ruta=public_path('/imagenes/'.$nombre);
            Image::make($file->getRealPath())
                ->resize(100,100, function ($constraint){
                    $constraint->aspectRatio();
                })
                ->save($ruta,70);
        }
        return $nombre;

    }
}
