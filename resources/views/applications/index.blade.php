<x-app-layout>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="w-full">
            @foreach ($applicaitons as $applicaiton)
                <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="mt-4 flex items-center space-x-4 py-6">
                            <div>
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ $applicaiton->volunteer->profile_photo_url }}"
                                        alt="{{ $applicaiton->volunteer->name }}" />
                                @endif
                            </div>
                            <div class="text-sm font-semibold">
                                {{ $applicaiton->volunteer->name }}
                            </div>
                            
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="{{ route('applicaitons.show', $applicaiton) }}"
                                    class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                    more
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="block mt-3">
                {{ $applicaitons->links() }}
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
