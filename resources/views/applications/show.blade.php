<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-4 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        <article class="mb-2">
            <div class="flex mt-1 mb-3">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div><img src="{{ $application->volunteer->user->profile_photo_url }}" alt=""
                            class="h-10 w-10 rounded-full object-cover bg-orange-300 mr-3"></div>
                @endif
                <h3 class="font-bold text-lg h-10 leading-10">{{ $application->volunteer->user->name }}</h3>
            </div>
            
            <div class="flex justify-between text-sm">
            <p class="text-gray-700 text-sm">経歴や希望する活動等</p>
             <div>
                    <span>更新日 : {{ $application->created_at->format('Y-m-d') }}</span>
                </div>
            </div>
            <div class="font-bold border-2 border-orange-200 rounded-lg">{!! nl2br(e($application->career)) !!}</div>
        </article>
        {{-- 13.エントリー store,destory npo画面で見える --}}
        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center my-4">
            @can('npo')
                @if (empty($propose))
                    <form action="{{ route('applications.proposes.store', $application) }}" method="post">
                        @csrf
                        <input type="submit" value="スカウト" onclick="if(!confirm('スカウトしますか？')){return false};"
                            class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-300 hover:to-orange-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @else
                    <form action="{{ route('applications.proposes.destroy', [$application, $propose]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="スカウト取消" onclick="if(!confirm('スカウトを取り消しますか？')){return false};"
                            class="bg-gradient-to-r from-emerald-400 to-emerald-500 hover:bg-gradient-to-l hover:from-emerald-400 hover:to-emerald-500 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @endif
            @endcan

            {{-- update/delete volunteer画面で見える --}}
            @can('update', $application)
                <a href="{{ route('applications.edit', $application) }}"
                    class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-600 hover:to-orange-300 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
            @can('delete', $application)
                <form action="{{ route('applications.destroy', $application) }}" method="post" class="w-full sm:w-32">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-gradient-to-r from-emerald-300 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-600 hover:to-emerald-400 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                </form>
            @endcan
        </div>

        {{-- テキスト１５  エントリー承認・却下 --}}
        @if (!empty($proposes))
            <hr>
            <h2 class="flex justify-center font-bold text-lg my-4">提案を受けたNPO・NGO一覧</h2>
            <div class="">
                <form method="post">
                    @csrf
                    @method('PATCH')
                    <table class="min-w-full table-fixed text-center">
                        <thead>
                            <tr class="text-gray-700 ">
                                <th class="w-1/5 px-4 py-2">NPO/NGO名</th>
                                <th class="w-1/5 px-4 py-2">提案日</th>
                                <th class="w-1/5 px-4 py-2">ステータス</th>
                                <th class="w-2/5 px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposes as $propose)
                                <tr>
                                    <td>{{ $propose->user->npo->name }}</td>
                                    <td>{{ $propose->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $propose->status_value }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center">
                                            @if (App\Models\Propose::STATUS_PROPOSE == $propose->status)
                                                <input type="submit" value="承認"
                                                    formaction="{{ route('applications.proposes.accept', [$application, $propose]) }}"
                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-emerald-300 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-600 hover:to-emerald-400 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                                <input type="submit" value="却下"
                                                    formaction="{{ route('applications.proposes.refuse', [$application, $propose]) }}"
                                                    onclick="if(!confirm('却下しますか？')){return false};"
                                                    class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-600 hover:to-orange-300 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 ml-2">
                                            @elseif (App\Models\Propose::STATUS_ACCEPT == $propose->status)
                                                {{-- @if (Route::has('proposes.messages.index')) --}}
                                                {{-- <a href="{{ route('proposes.messages.index', $propose) }}" --}}
                                                <a
                                                    class="bg-gradient-to-r bg-sky-400 hover:bg-gradient-to-l hover:bg-sky-500 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                                                {{-- @endif --}}
                                                <input type="submit" value="承認取消"
                                                    formaction="{{ route('applications.proposes.refuse', [$application, $propose]) }}"
                                                    onclick="if(!confirm('承認を取り消しますか？')){return false};"
                                                    class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-600 hover:to-orange-300 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            @else
                                                <input type="submit" value="再承認"
                                                    formaction="{{ route('applications.proposes.accept', [$application, $propose]) }}"
                                                    onclick="if(!confirm('再承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-emerald-300 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-600 hover:to-emerald-400 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
