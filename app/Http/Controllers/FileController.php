<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function processFile(Request $request)
    {
        $request->validate([
            'chosenFile' => 'required|mimes:txt',
            'symbol' => 'required|string',
        ]);

        //разбиваем файл по символу
        $content = $request->chosenFile->get();
        $pieces = explode($request->symbol, $content);

        $pieces = array_filter($pieces, function($element) {
            return !empty($element);
        });

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
