<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use FFMpeg\FFProbe;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConvertController extends Controller
{
    public function index()
    {
    	return view('convert');
    }

    public function convert(Request $request)
    {
       // dd($_SERVER);
       // $size = '270x480';
    	$name = str_random(10).'.gif';
        $width = 180;
    	$path = "../storage/app/public/{$name}";

        $ffprobe = FFProbe::create();
        $dimension = $ffprobe
            ->streams($request->video) // extracts streams informations
            ->videos()                      // filters video streams
            ->first()                       // returns the first video stream
            ->getDimensions();

        $height = (int)($width / ($dimension->getHeight() / $dimension->getWidth()));
        $wh = $width.'X'.$height;
    	$process = new Process("ffmpeg -i {$request->video} -s $wh -r 7 {$path} -hide_banner");
		$process->run();

		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
        // return [
        //     'url' => asset('storage/'.$name),
        //     'size' => \Storage::disk('public')->size($name)
        // ];
        $size = \Storage::disk('public')->size($name);
		return back()->with('gif', $name)->with('size', round($size / 1024 / 1024, 2).'M');
    }
}
