<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VolunteerOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class VolunteerOfferController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(VolunteerOffer::class, 'volunteer_offer');
    }

    public function index()
    {
        $volunteer_offers = VolunteerOffer::with('npo')
            ->published()->orderBy('updated_at', 'desc')->get();
        return response()->json(["data"=>$volunteer_offers]);
        // API前
        // $volunteer_offers = VolunteerOffer::with('npo')
        //     ->published()->latest()->paginate(5);
        // return view('volunteer_offers.index', compact('volunteer_offers'));
    }

    public function store(Request $request)
    {
        $volunteer_offer = new VolunteerOffer($request->all());
        $volunteer_offer->npo_id = $request->user()->npo->id;
        // 画像を取得   $file input typeのfile = $request->file(input nameの'image');
        $file = $request->file('image');
        // ファイル名を保存  取得したときの年月日時分秒      ファイル名を取得
        $volunteer_offer->image = self::createFileName($file);
        // トランザクション開始
        DB::beginTransaction();
        try {
            $volunteer_offer->save();
            // 写真本体保存に失敗した時   putFileファイルを送るAs名前を贈る 
            if (!Storage::putFileAs('images/volunteer_o$volunteer_offers', $file, $volunteer_offer->image)) {
                // 例外を投げてロールバックさせる
                //newある！インスタンス化だ！！＄\Exception = new \Exception;
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }
            // 写真本体に保存 トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
        DB::rollback();
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($volunteer_offer, 201); 
            // API前
        // $volunteer_offer = new VolunteerOffer($request->all());
        // $volunteer_offer->npo_id = $request->user()->npo->id;
        // try {
        //     // 登録
        //     $volunteer_offer->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('ボランティア募集情報の登録処理でエラーが発生しました');
        // }
        // return redirect()
        //     ->route('volunteer_offers.show', $volunteer_offer)
        //     ->with('notice', 'ボランティア募集情報を登録しました');
    }


    public function show(VolunteerOffer $volunteer_offer)
    {
        //npoなら テキストから変更  ！issetだった
        $scout = !isset(Auth::user()->npo)
            ? $volunteer_offer->scouts()->firstWhere('user_id', Auth::user()->id)
            : '';
        $scouts = Auth::user()->id == $volunteer_offer->npo->user_id
            ? $scouts = $volunteer_offer->scouts()->with('user')->get()
            : [];
        return response()->json($volunteer_offer);
        // API前
        // $scout = !isset(Auth::user()->npo)
        //     ? $volunteer_offer->scouts()->firstWhere('user_id', Auth::user()->id)
        //     : '';
        // $scouts = Auth::user()->id == $volunteer_offer->npo->user_id
        //     ? $scouts = $volunteer_offer->scouts()->with('user')->get()
        //     : [];

        // return view('volunteer_offers.show', compact('volunteer_offer', 'scout', 'scouts'));
    }

    public function update(Request $request, VolunteerOffer $volunteer_offer)
    {
        // if (Auth::user()->cannot('update', $volunteer_offer)) {
        //     return redirect()->route('volunteer_offers.show', $volunteer_offer)
        //         ->withErrors('自分の募集情報以外は更新できません');
        // }
        $volunteer_offer->fill($request->all());
        try {
            $volunteer_offer->save();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($volunteer_offer, 200);
        // API前
        // if (Auth::user()->cannot('update', $volunteer_offer)) {
        //     return redirect()->route('volunteer_offers.show', $volunteer_offer)
        //         ->withErrors('自分の募集情報以外は更新できません');
        // }
        // $volunteer_offer->fill($request->all());
        // try {
        //     $volunteer_offer->save();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('募集情報更新処理でエラーが発生しました');
        // }
        // return redirect()->route('volunteer_offers.show', $volunteer_offer)
        //     ->with('notice', '募集情報を更新しました');
    }

    public function destroy(VolunteerOffer $volunteer_offer)
    {
        // if (Auth::user()->cannot('delete', $volunteer_offer)) {
        //     return redirect()->route('volun$volunteer_offers.show', $volunteer_offer)
        //         ->withErrors('自分の募集情報以外は削除できません');
        // }
        try {
            $volunteer_offer->delete();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($volunteer_offer, 204);
        
        // API前
        // if (Auth::user()->cannot('delete', $volunteer_offer)) {
        //     return redirect()->route('volun$volunteer_offers.show', $volunteer_offer)
        //         ->withErrors('自分の募集情報以外は削除できません');
        // }
        // try {
        //     $volunteer_offer->delete();
        // } catch (\Exception $e) {
        //     return back()->withInput()
        //         ->withErrors('募集情報削除処理でエラーが発生しました');
        // }
        // return redirect()->route('volunteer_offers.index')
        //     ->with('notice', '募集情報を削除しました');
    }
}
