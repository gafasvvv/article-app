<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function store(){
        //メール送信
        return response()->json([
            'result' => true
        ]);
    }
}
