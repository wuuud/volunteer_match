<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-4 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />

        <article class="mb-2">
            <div class="flex justify-between text-sm">
                <div>
                    <span>掲載日 {{ $volunteer_offer->created_at->format('Y-m-d') }}</span>
                </div>
            </div>

            <h3 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $volunteer_offer->title }}</h3>
            <div class="flex mt-1 mb-3">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div><img src="{{ $volunteer_offer->npo->profile_photo_url }}" alt=""
                            class="h-10 w-10 rounded-full object-cover mr-3"></div>
                @endif
                <h3 class="text-lg h-10 leading-10">{{ $volunteer_offer->npo->name }}</h3>
            </div>
            <p class="text-gray-700 text-base">募集開始 {{ $volunteer_offer->start_date }}</p>
            <br>
            <p class="text-gray-700 text-base">{!! nl2br(e($volunteer_offer->description)) !!}</p>
        </article>
        {{-- 13.エントリー store,destory --}}
        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center my-4">
            @can('user')
                @if (empty($scout))
                    <form action="{{ route('volunteer_offers.scouts.store', $volunteer_offer) }}" method="post">
                        @csrf
                        <input type="submit" value="エントリー" onclick="if(!confirm('エントリーしますか？')){return false};"
                            class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @else
                    @if (App\Models\Scout::STATUS_APPROVAL == $scout->status)
                        {{-- @if (Route::has('scouts.messages.index'))
                            <a href="{{ route('scouts.messages.index', $scout) }}"
                                class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                        @endif --}}
                            <button class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</button>
                        {{-- @endif --}}
                    @endif
                    <form action="{{ route('volunteer_offers.scouts.destroy', [$volunteer_offer, $scout]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="エントリー取消" onclick="if(!confirm('エントリーを取り消しますか？')){return false};"
                            class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @endif
            @endcan

            {{-- update/delete --}}
            @can('update', $volunteer_offer)
                <a href="{{ route('volunteer_offers.edit', $volunteer_offer) }}"
                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
            @can('delete', $volunteer_offer)
                <form action="{{ route('volunteer_offers.destroy', $volunteer_offer) }}" method="post"
                    class="w-full sm:w-32">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                </form>
            @endcan
        </div>

        {{-- テキスト１５  エントリー承認・却下 --}}
        @if (!empty($scouts))
            <hr>
            <h2 class="flex justify-center font-bold text-lg my-4">エントリー一覧</h2>
            <div class="">
                <form method="post">
                    @csrf
                    @method('PATCH')
                    <table class="min-w-full table-fixed text-center">
                        <thead>
                            <tr class="text-gray-700 ">
                                <th class="w-1/5 px-4 py-2">氏名</th>
                                <th class="w-1/5 px-4 py-2">エントリー日</th>
                                <th class="w-1/5 px-4 py-2">ステータス</th>
                                <th class="w-2/5 px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scouts as $scout)
                                <tr>
                                    <td>{{ $scout->user->name }}</td>
                                    <td>{{ $scout->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $scout->status_value }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center">
                                            @if (App\Models\Scout::STATUS_SCOUT == $scout->status)
                                                <input type="submit" value="承認"
                                                    formaction="{{ route('volunteer_offers.scouts.approval', [$volunteer_offer, $scout]) }}"
                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                                <input type="submit" value="却下"
                                                    formaction="{{ route('volunteer_offers.scouts.reject', [$volunteer_offer, $scout]) }}"
                                                    onclick="if(!confirm('却下しますか？')){return false};"
                                                    class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 ml-2">
                                            @elseif (App\Models\Scout::STATUS_APPROVAL == $scout->status)
                                                {{-- @if (Route::has('scouts.messages.index'))
                                                    <a href="{{ route('scouts.messages.index', $scout) }}"
                                                        class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                                                @endif --}}
                                                <button class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</button>
                                                <input type="submit" value="承認済み"
                                                    formaction="{{ route('volunteer_offers.scouts.reject', [$volunteer_offer, $scout]) }}"
                                                    onclick="if(!confirm('承認を取り消しますか？')){return false};"
                                                    class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                            @else
                                                <input type="submit" value="再承認"
                                                    formaction="{{ route('volunteer_offers.scouts.approval', [$volunteer_offer, $scout]) }}"
                                                    onclick="if(!confirm('再承認しますか？')){return false};"
                                                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
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
