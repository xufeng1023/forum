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
    	$name = time().'.gif';
    	$path = "../storage/app/public/{$name}";

    	$process = new Process("ffmpeg -i {$request->video} -s 270x360 -r 8 {$path} -hide_banner");
		$process->run();

		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}

		return back()->with('gif', $name);
    }
}
