<x-app-layout>
    <img class="w-max p-0" src="{{ asset('/images/volunteerOffer_index.png') }}" alt="" height="60">
    <div class="container mx-auto md:w-1/2 displya:flex w-1/2 my-8 px-4 py-4 grid gap-x-8 gap-y-4">
        @foreach ($volunteer_offers as $volunteer_offer)
            <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                <div class="mt-4">
                    <div class="mt-4 flex items-center space-x-4 py-6">
                        <div>
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ $volunteer_offer->npo->profile_photo_url }}"
                                    alt="{{ $volunteer_offer->npo->name }}" />
                            @endif
                        </div>
                        <div class="text-sm font-semibold">
                            {{ $volunteer_offer->npo->name }}
                        </div>
                    </div>
                    <h2 class="text-lg text-gray-700 font-semibold">{{ $volunteer_offer->title }}
                    </h2>
                    <div class="text-gray-700 text-sm text-left">
                        <span>募集開始 : {{ $volunteer_offer->start_date }}</span>
                    </div>
                    <p class="mt-4 text-md text-gray-600">
                        {{ Str::limit($volunteer_offer->description, 50, '...') }}
                    </p>
                    <div class="flex justify-between items-center">
                        <div>
                            {{-- application用に修正 --}}
                            <a href="{{ route('volunteer_offers.show', $volunteer_offer) }}"
                                class="right-0 flex justify-center bg-emerald-500 hover:bg-green-400 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                詳細
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
    <div class="block mt-3">
        {{ $volunteer_offers->links() }}
    </div>
</x-app-layout>
