<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicationRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(Application::class, 'application');
    }

    public function index(Request $request)
    {
        //API後・認証後
        $career = $request->career;
        $params = $request->query();
        $applications = Application::with('proposes')->search($params)->latest()->paginate(4);
        $applications->appends(compact('career'));
        return response()->json($applications);

        //API前
        // $career = $request->career;
        // $params = $request->query();
        // $applications = Application::search($params)->latest()->paginate(4);
        // $applications->appends(compact('career'));
        // return response()->json($applications);
        // return view('applications.index')->with(compact('applications'));
    }

    public function store(Request $request)
    {
        
        // 認証後
        $application = new Application($request->all());
        $application->volunteer_id = $request->user()->volunteer->id;
        try {
            $application->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($application, 201); 

        // API後
        // $application = new Application($request->all());
        // $application->volunteer_id = 1;
        // try {
        //     $application->save();
        // } catch (\Exception $e) {
        //     logger($e->getMessage());
        //     // return back()->withInput()->withErrors($e->getMessage());
        //     return response(status: 500);
        // }
        // return response()->json($application, 201);     //201 created作成しましたよ

        //  API前
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
        // 認証後
        $propose = !isset(Auth::user()->volunteer)
            ? $application->proposes()->firstWhere('user_id', Auth::user()->id)
            : '';
        $proposes = Auth::user()->id == $application->volunteer->user_id
            ? $proposes = $application->proposes()->with('user')->get()
            : [];
        $messages = $application->messages->load('user');
        return response()->json(compact('application', 'propose', 'proposes', 'messages'));

        // API後
        // $propose = $application->proposes()->firstWhere('user_id', 21);
        // $proposes = 21 == $application->volunteer->user_id
        //     ? $proposes = $application->proposes()->with('user')->get()
        //     : [];
        // $messages = $application->messages->load('user');
        // return response()->json(compact('application', 'propose', 'proposes', 'messages'));

        // API前
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
        // 認証後
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

        // API後
        // $application->fill($request->all());
        // try {
        //     $application->save();
        // } catch (\Exception $e) {
        //     logger($e->getMessage());
        //     return response(status: 500);
        // }
        // return response()->json($application, 200);

        // // API前
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
        // 認証後
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

        // API後
        // if (Auth::user()->cannot('delete', $application)) {
        //     return redirect()->route('$applications.show', $application)
        //         ->withErrors('自分の経歴等以外は削除できません');
        // }
        // try {
        //     $application->delete();
        // } catch (\Exception $e) {
        //     logger($e->getMessage());
        //     return response(status: 500);
        // }
        // return response()->json($application, 204);

        // API前
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
