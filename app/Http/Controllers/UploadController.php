<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function imgupload(Request $request){

        $path = $request->file('wangeditor-uploaded-image')->store('img','public');
        // dd($request);
        $result = [
            "errno"=> 0, // 注意：值是数字，不能是字符串
            "data"=> [
                "url"=> asset('storage/'.$path), // 图片 src ，必须
                "alt"=> "yyy", // 图片描述文字，非必须
                "href"=> asset('storage/'.$path)// 图片的链接，非必须
            ]
        ];
        return response()->json($result);
    }

}
