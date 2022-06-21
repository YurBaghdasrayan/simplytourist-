<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InviteFriend;

class inviteFriendsController extends Controller
{
    public function store(Request $request)
    {
//        dd(auth()->user());
        $data = [
            'reciver_id' => $request->reciver_id,
            'sender_id' => auth()->user()->id
        ];

//        $data->sender_id = auth()->user()->id;
        $invite = InviteFriend::create($data);

        if ($invite) {
            return response()->json([
                'success'=>true
            ]);
        }else{
            return response()->json([
                'success'=>false
            ]);
        }
    }
}
