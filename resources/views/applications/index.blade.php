<x-app-layout>
    <div class="relative flex">
        <div
            class="flex flex-col sm:flex-row items-center md:items-start sm:justify-center md:justify-start flex-auto min-w-0 bg-white">
            <div class="h-full flex flex-auto bg-purple-900 text-white relative bg-indeximage">
                <div class="h-full center md-1/2 flex-auto text-white">
                    {{--    <div class="w-4/5 flex flex-auto flex-col md:flex-row items-center justify-center p-10 xl:p-32 overflow-hidden">
                    <div class="absolute bg-gradient-to-b from-amber-200 to-black opacity-75 inset-0 z-0"></div>
                    <div class="w-4/5 z-10"> --}}
                    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
                        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                            @can('npo')
                                <article class="flex w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                                    <div class="post-search-form md-6">
                                        <h2>希望内容等検索</h2>
                                    </div>
                                        <form class="form-inline" action="{{ route('applications.index') }}" method="GET">
                                            @csrf
                                            <div class="form-group p-md-2">
                                                <input type="search" name="career" class="form-control"
                                                    placeholder="人物像等">
                                                <input type="submit" value="検索"
                                                    class="justify-center bg-gradient-to-r from-orange-400 to-orange-500 hover:bg-gradient-to-l text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                                            </div>
                                        </form>
                                    </div>
                                </article>
                            @endcan
                            <br>
                            <br>
                            {{-- <div class="text-5xl sm:text-6xl xl:text-8xl font-bold leading-tight mb-6">
                        </div>
                        <div class="sm:text-sm xl:text-md text-gray-200 font-normal"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}



    {{-- <div class="mx-auto w-3/5 my-8 px-3 py-3">
                        @can('npo')
                            <div class="post-search-form md-6">
                                <h2>希望内容等検索</h2>
                                <form class="form-inline" action="{{ route('applications.index') }}" method="GET">
                                    @csrf
                                    <div class="form-group p-md-2">
                                        <input type="search" name="career" class="form-control" placeholder="人物像等">
                                        <input type="submit" value="検索"
                                            class="justify-center bg-gradient-to-r from-orange-400 to-orange-500 hover:bg-gradient-to-l text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                                    </div>
                                </form>
                            </div>
                        @endcan  --}}


    {{-- myapplication --}}
    {{-- @can('create')
                <a href="{{ route('applications.create') }}"
                    class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-600 hover:to-orange-300 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
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
            @endcan --}}

    {{-- 全件表示 --}}
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="w-full">
            @foreach ($applications as $application)
                <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="mt-4 flex items-center space-x-4 py-6">
                            <div>
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="h-8 w-8 rounded-full object-cover bg-merald-80"
                                        src="{{ $application->volunteer->user->profile_photo_url }}" />
                                @endif
                            </div>
                            <div class="text-sm font-semibold">
                                {{ $application->volunteer->user->name }}
                            </div>
                        </div>
                        <div>
                            <p class="mt-4 text-md text-gray-600">
                                {{ Str::limit($application->career, 50, '...') }}
                            </p>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <a href="{{ route('applications.show', $application) }}"
                                    class="flex justify-center bg-gradient-to-r from-emerald-500 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-600 hover:to-emerald-400 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                    詳細
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
            <div class="block mt-3">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
