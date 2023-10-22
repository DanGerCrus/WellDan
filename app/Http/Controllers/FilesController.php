<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FilesController extends Controller
{
    /**
     * Возвращаем файл
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function get(Request $request): BinaryFileResponse
    {
        $link = urldecode($request->getRequestUri());
        $link = preg_replace('/\?(.*)/', '', $link);
        $path = env('STORAGE_URL')  . $link;
        abort_if(!file_exists($path), 404);

        return response()->file($path);
    }

}
