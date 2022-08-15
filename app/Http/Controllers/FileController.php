<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function processFile(Request $request)
    {
        $request->validate([
            'chosenFile' => 'required|mimes:txt',
            'symbol' => 'required|string',
        ]);
        //разбиваем файл по символу
        $content = $request->chosenFile->get();
        $pieces = explode($request->symbol, $content);

        return response(['pieces' => $pieces]);
    }

    public function changeFolders(Request $request)
    {
        $request->validate([
            'folder_from' => 'required|string',
            'folder_to' => 'required|string',
            'time' => 'required|string',
        ]);

        return 'OK';
    }
}
