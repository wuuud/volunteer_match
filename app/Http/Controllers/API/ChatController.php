<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Propose;
use App\Models\Message;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Gate;
use App\Events\MessageSend;

class ChatController extends Controller
{
    public function index(Propose $propose)
    {
        // Gate::authorize('message', $propose);
        $messages = $propose->messages->load('user');
        return response()->json(compact(['messages', 'propose']));
        // Gate::authorize('message', $propose);
        // $messages = $propose->messages->load('user');
        // return view('chat', compact(['messages', 'propose']));
    }

    public function store(Request $request, Propose $propose)
    {
        // Gate::authorize('message', $propose);

        $message = new Message($request->all());
        $message->messageable_type = 'App\Models\Propose';
        $message->messageable_id = $propose->id;
        $message->user_id = 21;
        $message->save();
        // イベントを発火します
        event(new MessageSend($message));
        return response()->json($message, 201);

        // public function store(Propose $propose, Request $request)
    // {
        // Gate::authorize('message', $propose);

        // $message = new Message($request->all());
        // $message->messageable_type = 'App\Models\Propose';
        // $message->user_id = Auth::id();

        // $message->save();
        // // イベントを発火します
        // event(new MessageSend($message));
        // return response()->json(['message' => '投稿しました。']);
    }

    public function destroy(Propose $propose, Message $message)
    {
        // Gate::authorize('message', $propose);
        $message->delete();
        return response()->json($message, 204);

        // Gate::authorize('message', $propose);
        // $message->delete();
        // return response()->json(['message' => '投稿しました。']);
    }
}
