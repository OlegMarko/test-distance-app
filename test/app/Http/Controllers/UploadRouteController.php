<?php

namespace App\Http\Controllers;

use App\Services\ParseFileService;
use Illuminate\Http\Request;

class UploadRouteController extends Controller
{
    /**
     * Get upload file page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadForm()
    {
        return view('upload-route');
    }

    /**
     * Upload file.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $data = ParseFileService::parseFile($file);

        return response()->json(['message' => $data], 200);
    }
}
