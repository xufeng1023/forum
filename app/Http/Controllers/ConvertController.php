<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConvertController extends Controller
{
    public function index()
    {
    	return view('convert');
    }

    public function convert(Request $request)
    {
       // $size = '270x480';
    	$name = str_random(10).'.gif';
    	$path = "../storage/app/public/{$name}";

       // if($request->ratio == '3/4' || $request->ratio == '4/3') $size = '270x360';

    	$process = new Process("ffmpeg -i {$request->video} -s 240x320 -r 5 {$path} -hide_banner");
		$process->run();

		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}

		return back()->with('gif', $name);
    }
}
