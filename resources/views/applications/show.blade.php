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
                <div class="font-bold">
                    <span>更新日 : {{ $application->updated_at->format('Y-m-d') }}</span>
                </div>
            </div>
            <label name="career" rows="10"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-orange-600 w-full py-2 px-3">{!! nl2br(e($application->career)) !!}
            </label>
        </article>
        {{-- 13.スカウト store,destory npo画面で見える --}}
        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center my-4">
            @can('npo')
                @if (empty($propose))
                    <form action="{{ route('applications.proposes.store', $application) }}" method="post">
                        @csrf
                        <input type="submit" value="スカウト" onclick="if(!confirm('スカウトしますか？')){return false};"
                            class="bg-gradient-to-r from-orange-400 to-orange-500 hover:bg-gradient-to-l hover:from-orange-500 hover:to-orange-400 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                    </form>
                @else
                    {{-- 0:スカウト中(デフォルト) 1:承認 2:却下　$propose->status  proposeモデルに記載 --}}
                    @if (App\Models\Propose::STATUS_ACCEPT == $propose->status)
                        {{--            下記のrouteを確認 --}}
                        @if (Route::has('proposes.messages.index'))
                            <a href="{{ route('proposes.messages.index', $propose) }}"
                                class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">
                                メッセージ
                            </a>
                        @endif
                    @endif
                    <form action="{{ route('applications.proposes.destroy', [$application, $propose]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="スカウト取消" onclick="if(!confirm('スカウトを取り消しますか？')){return false};"
                            class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-500 hover:to-emerald-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
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

        {{-- メッセージ --}}
        <br>
        <div id="messages"
            class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            @foreach ($messages as $message)
                @if ($message->user_id == Auth::user()->id)
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <form action="{{ route('applications.messages.destroy', [$application, $message]) }}"
                                method="post" id="destroyMessage">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button form="destroyMessage" onclick="if(!confirm('メッセージを削除しますか？')){return false};">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                            <div class="text-gray-600 text-sm">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</div>
                            <div class="flex flex-col space-y-2 text-lg max-w-lg mx-2 items-end">
                                <div>
                                    <span
                                        class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white">{{ $message->message }}</span>
                                </div>
                            </div>
                            <img class="w-6 h-6 rounded-full" src="{{ $message->user->profile_photo_url }}"
                                alt="{{ $message->user->name }}" />
                        </div>
                    </div>
                @else
                    <div class="chat-message">
                        <div class="flex items-end">
                            <img class="w-6 h-6 rounded-full " src="{{ $message->user->profile_photo_url }}"
                                alt="{{ $message->user->name }}" />
                            <div class="flex flex-col space-y-2 text-lg max-w-lg mx-2 items-start">
                                <div>
                                    <span
                                        class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">{{ $message->message }}</span>
                                </div>
                            </div>
                            <div class="text-gray-600 text-sm">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <br>

        {{-- テキスト１５  スカウト承認・却下 --}}
        @if (!empty($proposes))
            <hr>
            <h2 class="flex justify-center font-bold text-lg my-4">スカウトを受けたNPO・NGO一覧</h2>
            <div class="">
                <form method="post">
                    @csrf
                    @method('PATCH')
                    <table class="min-w-full table-fixed text-center">
                        <thead>
                            <tr class="text-gray-700 ">
                                <th class="w-1/5 px-4 py-2">NPO/NGO名</th>
                                <th class="w-1/5 px-4 py-2">ボランティア内容</th>
                                <th class="w-1/5 px-4 py-2">スカウト日</th>
                                <th class="w-1/5 px-4 py-2">ステータス</th>
                                <th class="w-2/5 px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposes as $propose)
                                <tr>
                                    <td>
                                        <a href="{{ route('volunteer_offer.show', $volunteer_offer) }}">
                                            {{ $propose->user->npo->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('volunteer_offer.show', $volunteer_offer) }}"> --}}
                                            {{ $propose->user->npo->volunteer_offers }}
                                        {{-- </a> --}}
                                    </td>
                                    <td>{{ $propose->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $propose->status_value }}</td>
                                    <td>
                                        <div class="flex flex-col sm:flex-row items-centerimage.png sm:justify-end text-center">
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
                                                @if (Route::has('proposes.messages.index'))
                                                    <a href="{{ route('proposes.messages.index', $propose) }}"
                                                        class="bg-gradient-to-r bg-sky-400 hover:bg-gradient-to-l hover:bg-sky-500 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">メッセージ</a>
                                                @endif
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
    {{-- メッセージ --}}
    <div
        class="border-t-2 border-gray-200 pt-4 mb-2 sm:mb-0 sticky bottom-0 lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-4 py-4 bg-white">
        <div class="relative flex">
            <span class="absolute inset-y-0 flex items-center">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                </button>
            </span>
            <input type="hidden" id="messageable_id" name="messageable_id" value="{{ $application->id }}"
                form="sendMessage">
            <input type="text" placeholder="メッセージを入力" name="message" form="sendMessage"
                class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3">
            <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                        </path>
                    </svg>
                </button>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
                <button type="button"
                    class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </button>
                <button type="submit" id="submit" form="sendMessage"
                    class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                    <span class="font-bold">送信</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="h-6 w-6 ml-2 transform rotate-90">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                        </path>
                    </svg>
                </button>
                <form method="post" action="{{ route('applications.messages.store', $application) }}"
                    id="sendMessage">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
