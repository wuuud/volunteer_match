<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Propose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposeController extends Controller
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
        $propose = new Propose([
            'application_id' => $application->id,
            'user_id' => $request->user()->id,
        ]);
        try {
            $propose->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($propose, 201);


        // API後
        $propose = new Propose([
            'application_id' => $application->id,
            'user_id' => 1,
        ]);
        try {
            $propose->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($propose, 201);

        // API前
        // $propose = new Propose([
        //     'application_id' => $application->id,
        //     'user_id' => Auth::user()->id,
        // ]);
        // try {
        //     $propose->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('スカウトでエラーが発生しました');
        //         // ->withErrors($e->getMessage());
        // }
        // return redirect()
        //     ->route('applications.show', $application)
        //     ->with('notice', 'スカウトしました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @param  \App\Models\Propose  $propose
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application, Propose $propose)
    {
        // 認証後
        $propose->delete();
        return response()->json($propose, 204);
        
        // API後
        $propose->delete();
        return response()->json($propose, 204);

        // API前
        // $propose->delete();
        // return redirect()->route('applications.show', [$application, $propose])
        //     ->with('notice', 'スカウトを取り消しました');
    }

    /**
     *
     * @param  \App\Models\Application $application
     * @param  \App\Models\Propose $propose
     * @return \Illuminate\Http\Response
     */
    public function accept(Application $application, Propose $propose)
    {
        // 認証後
        $propose->status = Propose::STATUS_ACCEPT;
        $propose->save();
        return response()->json($propose, 201);
        
        // API後
        // $propose->status = Propose::STATUS_ACCEPT;
        $propose->save();
        return response()->json($propose, 201);

        // API前
        // $propose->status = Propose::STATUS_ACCEPT;
        // $propose->save();
        // return redirect()->route('applications.show', $application)
        //     ->with('notice', 'スカウトを承認しました');
    }

    /**
     *
     * @param  \App\Models\Application $application
     * @param  \App\Models\Propose $propose
     * @return \Illuminate\Http\Response
     */
    public function refuse(Application $application, Propose $propose)
    {
        
        // 認証後
        $propose->status = Propose::STATUS_REFUSE;
        $propose->save();
        return response()->json($propose, 200);
        
        // API後
        // $propose->status = Propose::STATUS_REFUSE;
        $propose->save();
        return response()->json($propose, 200);
        
        // API前
        // $propose->status = Propose::STATUS_REFUSE;
        // $propose->save();
        // return redirect()->route('applications.show', $application)
        //     ->with('notice', 'スカウトを却下しました');
    }
}
