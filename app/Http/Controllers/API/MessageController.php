<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Application $application)
    {
        // 認証後
        $message = new Message($request->all());
        $message->messageable_id = $request->messageable_id;
        $message->messageable_type = 'App\Models\Application';
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        try {
            $message->save();
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response('', 500);
        }
        // $application = Application::find($request->messageable_id);
        return response()->json($message, 201);
        
        // API後
        $message = new Message($request->all());
        $message->messageable_type = 'App\Models\Application';
        $message->messageable_id = $application->id;
        $message->user_id = 1;
        $message->message = $request->message;
        try {
            $message->save();
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response('', 500);
        }
        // $application = Application::find($request->messageable_id);
        return response()->json($message, 201);

        // API前
        // $message = new Message($request->all());
        // $message->messageable_id = $request->messageable_id;
        // $message->user_id = Auth::user()->id;
        // $message->message = $request->message;
        // try {
        //     $message->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('メッセージ登録処理でエラーが発生しました');
        // }
        // $application = Application::find($request->messageable_id);
        // return redirect()
        //     ->route('applications.show', $application)
        //     ->with('notice', 'メッセージを登録しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application, Message $message)
    {
        // 認証後
        $application = $message->messageable;
        // if (Auth::user()->id != $message->user_id) {
        //     return redirect()->route('applications.show', $application)
        //         ->withErrors('自分のメッセージ以外は削除できません');
        // }
        try {
            $message->delete();
        } catch (\Exception $th) {
            logger($th->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 204);

        
        // API後
        $application = $message->messageable;
        // if (Auth::user()->id != $message->user_id) {
        //     return redirect()->route('applications.show', $application)
        //         ->withErrors('自分のメッセージ以外は削除できません');
        // }
        try {
            $message->delete();
        } catch (\Exception $th) {
            logger($th->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 204);

        // API前
        // $application = $message->messageable;
        // if (Auth::user()->id != $message->user_id) {
        //     return redirect()->route('applications.show', $application)
        //         ->withErrors('自分のメッセージ以外は削除できません');
        // }
        // try {
        //     $message->delete();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('メッセージ削除処理でエラーが発生しました');
        // }
        // return redirect()->route('applications.show', $application)
        //     ->with('notice', ' メッセージを削除しました');
    }
}
