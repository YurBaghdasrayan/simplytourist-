<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsergroupThemes;

class usergroupDeleteController extends Controller
{
    public function destroy(Request $request, $id)
    {
        $update = UsergroupThemes::where('id',$id)->get();
        $data = $request->all();
        $update[0]->status = $data['status'];
        $update[0]->save();
    }
}
