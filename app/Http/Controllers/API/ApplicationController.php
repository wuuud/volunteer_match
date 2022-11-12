<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /// 検索
        $career= $request->career;
        $params = $request->query();
        $applications = Application::search($params)->latest()->paginate(4);
        $applications->appends(compact('career'));
        // return view('applications.index')->with(compact('applications'));
        return response()->json($applications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $application = new Application($request->all());
        $application->volunteer_id = 1;
        try {
            $application->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            // return back()->withInput()->withErrors($e->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 201);     //201 created作成しましたよ
        // $application = new Application($request->all());
        // $application->volunteer_id = $request->user()->volunteer->id;
        // try {
        //     $application->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('経歴等登録処理でエラーが発生しました');
        // }
        // return redirect()
        //     ->route('applications.show', $application)
        //     ->with('notice', '経歴等を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        $propose = $application->proposes()->firstWhere('user_id', 21);
        $proposes = 21 == $application->volunteer->user_id
            ? $proposes = $application->proposes()->with('user')->get()
            : [];
        $messages = $application->messages->load('user');
        return response()->json(compact('application', 'propose', 'proposes', 'messages'));

        // $propose = !isset(Auth::user()->volunteer)
        //     ? $application->proposes()->firstWhere('user_id', Auth::user()->id)
        //     : '';
        // $proposes = Auth::user()->id == $application->volunteer->user_id
        //     ? $proposes = $application->proposes()->with('user')->get()
        //     : [];
        // $messages = $application->messages->load('user');

        // return view('applications.show')
        //     ->with(compact('application', 'propose', 'proposes', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ApplicationRequest  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, Application $application)
    {
        // if ( $application->user_id = 21 -> cannot('update', $application)) {
        //     return redirect()->route('applications.show', $application)
        //         ->withErrors('自分の経歴等以外は更新できません');
        // }
        $application->fill($request->all());
        try {
            $application->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 200);

        // if (Auth::user()->cannot('update', $application)) {
        //     return redirect()->route('applications.show', $application)
        //         ->withErrors('自分の経歴等以外は更新できません');
        // }
        // $application->fill($request->all());
        // try {
        //     $application->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('経歴等の更新処理でエラーが発生しました');
        // }
        // return redirect()->route('applications.show', $application)
        //     ->with('notice', '経歴等を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        // if (Auth::user()->cannot('delete', $application)) {
        //     return redirect()->route('$applications.show', $application)
        //         ->withErrors('自分の経歴等以外は削除できません');
        // }
        try {
            $application->delete();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 204);

        // if (Auth::user()->cannot('delete', $application)) {
        //     return redirect()->route('$applications.show', $application)
        //         ->withErrors('自分の経歴等以外は削除できません');
        // }
        // try {
        //     $application->delete();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('経歴等削除処理でエラーが発生しました');
        // }
        // return redirect()->route('applications.index')
        //     ->with('notice', '経歴等を削除しました');
    }
}