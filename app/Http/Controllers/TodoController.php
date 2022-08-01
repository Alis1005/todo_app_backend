<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Todos;


class TodoController extends Controller
{
    public function add(Request $request)
    {
        $user = Auth::user();
        $data = Todos::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'duration' => $request->input('duration'),
            'status' => 0
        ]);
        return response([
            'data' => $data
        ], 200);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = Todos::where('user_id', $user->id)->wherein('id', explode(',', $request->input('ids')))->update([
            'status' => $request->input('status')
        ]);
        return response([
            'data' => $data
        ], 200);
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        $data = Todos::where('user_id', $user->id)->where('id', $request->input('id'))->delete();
        return response([
            'data' => $data
        ], 200);
    }
    public function get(Request $request)
    {
        $user = Auth::user();
        $data = Todos::where('user_id', $user->id)->get();
        return response([
            'data' => $data
        ], 200);
    }
}
