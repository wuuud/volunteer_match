<?php

namespace App\Http\Controllers;

use App\Models\Applicaiton;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicaitonRequest;

class ApplicaitonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('applicaitons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ApplicaitonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicaitonRequest $request)
    {
        // $applicaiton = new Applicaiton($request->all());
        // $applicaiton->volunteer_id = $request->user()->volunteer->id;
        // try {
        //     // 登録
        //     $applicaiton->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('求人情報登録処理でエラーが発生しました');
        // }
        // return redirect()
        //     ->route('job_offers.show', $applicaiton)
        //     ->with('notice', '求人情報を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicaiton  $applicaiton
     * @return \Illuminate\Http\Response
     */
    public function show(Applicaiton $applicaiton)
    {
        return view('applicaitons.show', compact('job_offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applicaiton  $applicaiton
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicaiton $applicaiton)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ApplicaitonRequest  $request
     * @param  \App\Models\Applicaiton  $applicaiton
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicaitonRequest $request, Applicaiton $applicaiton)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicaiton  $applicaiton
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicaiton $applicaiton)
    {
        //
    }
}
