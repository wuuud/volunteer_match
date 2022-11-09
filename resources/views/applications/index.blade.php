<x-app-layout>
    <div class="mx-auto w-3/5 my-8 px-3 py-3">
        {{-- 検索 https://qiita.com/hinako_n/items/7729aa9fec522c517f2a --}}
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
        @endcan
        
        {{-- prodashboard --}}
            @can('create')
                <a href="{{ route('applications.create') }}"
                    class="bg-gradient-to-r from-orange-300 to-orange-600 hover:bg-gradient-to-l hover:from-orange-600 hover:to-orange-300 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
            {{-- @can('update', $application)
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
                                        src="{{ $application->volunteer->user->profile_photo_url }}"
                                        alt="{{ $application->volunteer->user->name }}" />
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
                <hr>
            @endforeach
            <div class="block mt-3">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
