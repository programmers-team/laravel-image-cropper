<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $filename = $request->photo->hashName();
        $path = $request->file('photo')->store('public/photos');
        return response()->json(['filename' => $filename]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateImage(Request $request)
    {
        if ($request->w && $request->h && $request->img) {
           $img = Image::make('storage/photos/'.$request->img)->fit($request->w, $request->h);
           $width = $request->w;
           $height = $request->h;
           $extension = $img->extension;
           $headers = [
               'Content-Type' => 'image/'.$img->extension
           ];
           return response()->streamDownload(function () use ($img,$width,$height,$extension) {
               echo $img->encode($extension, 100);
           }, $width."x".$height.'.'.$extension, $headers);
        }
    }

    public function createZip(Request $request)
    {

        $widths = $request->width;
        $heights = $request->height;
        $filename = $request->filename;
        $foldername = uniqid(Carbon::now()->micro);

        if ((!empty($widths)) && (!empty($heights)) && (!empty($filename))) {
            $directory = "public/photos/".$foldername;
            Storage::makeDirectory($directory);
            foreach ($widths as $key => $width) {
                $height = $heights[$key];
                $img = Image::make('storage/photos/'.$filename)->fit($width, $height);
                $extension = $img->extension;
                $img->save(storage_path().'/app/'.$directory.'/'.$width."x".$height.'.'.$extension, 100);
            }
        }

        $zipname = storage_path()."/app/public/photos/".$foldername.'.zip';
        $files = glob(storage_path().'/app/public/photos/'.$foldername.'/*.*');
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files as $file) {
          $onlyfilename = str_replace(storage_path()."/app/public/photos/".$foldername."/","",$file);
          $zip->addFile($file,$onlyfilename);
        }
        $zip->close();
        Storage::deleteDirectory($directory);
        return response()->json(['filename' => $foldername.'.zip']);

    }

    public function downloadAll(Request $request)
    {
        $filename = $request->filename;
        if ($filename) {
            return Storage::download('public/photos/'.$filename);
        }
    }

}
