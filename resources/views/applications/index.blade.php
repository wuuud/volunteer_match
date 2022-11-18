<x-app-layout>
    <div class="relative flex">
        <div
            class="flex flex-col sm:flex-row items-center md:items-start sm:justify-center md:justify-start flex-auto min-w-0 bg-white">
            <div class="h-full flex flex-auto bg-orage-100 text-white relative bg-indeximage">
                <div class="h-full center md-1/2 flex-auto text-white">
                    <div class="container mx-auto md:w-1/2 displya:flex w-1/2 my-8 px-4 py-4 grid gap-x-8 gap-y-4">
                        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                            @can('npo')
                                <article class="flex w-full px-4 md:w text-xl text-gray-800 leading-normal">
                                    <div class="post-search-form md-6">
                                        <h2>スカウト人材検索</h2>
                                        {{-- </div>
                                        <div> --}}
                                        <form class="form-inline" action="{{ route('applications.index') }}" method="GET">
                                            @csrf
                                            <div class="form-group p-md-2">
                                                <input type="search" name="career" class="form-control"
                                                    placeholder="キーワード">
                                                <input type="submit" value="検索"
                                                    class="justify-center bg-gradient-to-r from-orange-400 to-orange-500 hover:bg-gradient-to-l text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                                            </div>
                                        </form>
                                    </div>
                                </article>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <div class="text-xl font-semibold">
                                {{ $application->volunteer->user->name }}
                            </div>
                        </div>
                        <div>
                            <p class="mt-4 text-md text-gray-600">
                                更新日：{{ $application->volunteer->updated_at->format('Y-m-d') }}
                            </p>
                        </div>
                        <div>
                            <p class="mt-4 text-md text-gray-600">
                                経歴等：{{ Str::limit($application->career, 50, '...') }}
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
</x-app-layout>
