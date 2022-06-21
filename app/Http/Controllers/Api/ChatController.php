<?php
//
//namespace App\Http\Controllers\Api;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use App\Models\Chat;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
//
//
//class ChatController extends Controller
//{
//    public function index($id)
//    {
//
//    }
//
//    public function allChat()
//    {
//
////        $allChat = Chat::where('sender_id', Auth::user()->id)
////            ->orWhere('reciver_id', Auth::user()->id)->orderBy('id','desc')->groupBy('group_id')
////            ->get();
//$user_id = Auth::user()->id;
//        $sql = DB::select("SELECT * FROM `chat_users` where `sender_id`= $user_id OR `reciver_id` = $user_id GROUP BY `group_id`");
//        dd($sql);
//
//
//    }
//    public function store(Request $request)
//    {
//        $file = $request->file('file');
//        if ($file) {
//            $destinationPath = 'public/uploads';
//            $user_image = time() . $file->getClientOriginalName();
//            $file->storeAs($destinationPath, $user_image);
//        }
//        $chatData = [
//            'sender_id' => Auth::user()->id,
//            'reciver_id' => $request->reciver_id,
//            'message' => $request->message,
//            'file' => $user_image,
//        ];
//
//        $creteChat = Chat::create($chatData);
//
//        if ($creteChat) {
//            return response()->json([
//                "success" => true,
//                "message" => "ok",
//                "data" => $creteChat
//            ]);
//        } else {
//            return response()->json([
//                'success' => false
//            ]);
//        }
//    }
//}
