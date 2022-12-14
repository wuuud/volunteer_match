<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Propose;
use Illuminate\Support\Facades\Auth;

class ProposeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function store(Application $application)
    {
        $propose = new Propose([
            'application_id' => $application->id,
            'user_id' => Auth::user()->id,
        ]);
        try {
            $propose->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('スカウトでエラーが発生しました');
                // ->withErrors($e->getMessage());
        }
        return redirect()
            ->route('applications.show', $application)
            ->with('notice', 'スカウトしました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application $application
     * @param  \App\Models\Propose $propose
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application, Propose $propose)
    {
        $propose->delete();
        return redirect()->route('applications.show', [$application, $propose])
            ->with('notice', 'スカウトを取り消しました');
    }
    /**
     *
     * @param  \App\Models\Application $application
     * @param  \App\Models\Propose $propose
     * @return \Illuminate\Http\Response
     */
    public function accept(Application $application, Propose $propose)
    {
        $propose->status = Propose::STATUS_ACCEPT;
        $propose->save();
        return redirect()->route('applications.show', $application)
            ->with('notice', 'スカウトを承認しました');
    }

    /**
     *
     * @param  \App\Models\Application $application
     * @param  \App\Models\Propose $propose
     * @return \Illuminate\Http\Response
     */
    public function refuse(Application $application, Propose $propose)
    {
        $propose->status = Propose::STATUS_REFUSE;
        $propose->save();
        return redirect()->route('applications.show', $application)
            ->with('notice', 'スカウトを却下しました');
    }
}
