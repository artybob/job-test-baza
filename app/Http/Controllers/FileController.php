<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{

    public function index()
    {
        $fileUrls = unserialize(file_get_contents("files_config.txt"));

        return view('job_task', [
            'file_urls' => $fileUrls
        ]);
    }

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

        $pieces = array_filter($pieces, function ($element) {
            return !empty($element);
        });

        return response(['pieces' => $pieces]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function changeFolders(Request $request)
    {
        $request->validate([
            'folder_from' => 'required|string',
            'folder_to' => 'required|string'
        ]);

        $conf = [
            'folder_from' => $request->folder_from,
            'folder_to' => $request->folder_to,
        ];

        $fd = fopen("files_config.txt", 'w');

        fwrite($fd, serialize($conf));

        return response(['msg' => 'urls changed']);
    }
}
