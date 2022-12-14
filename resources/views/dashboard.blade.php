<x-app-layout>
    <div class="container mx-auto md:w-1/2 displya:flex w-1/2 my-8 px-4 py-4 grid gap-x-8 gap-y-4">
        @can('npo')
            <div class="flex justify-end items-center mb-3">
                <h4 class="text-gray-400 text-sm">公開状況</h4>
                <ul class="flex">
                    @foreach (App\Models\VolunteerOffer::STATUS_LIST as $value => $name)
                        <li class="ml-4">
                            <a href="?is_published={{ $value }}"
                                class="hover:text-blue-500 
                                    @if (Request::get('is_published') === (string) $value ||
                                        (Request::get('is_published') === null && App\Models\VolunteerOffer::STATUS_OPEN == $value)) text-green-500 font-bold @endif
                                ">
                                {{ $name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endcan
        <div>
            @foreach ($volunteer_offers as $volunteer_offer)
                <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex justify-between text-sm items-center mb-4">
                            {{-- <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">{{ $j->occupation->name }}</div> --}}
                            <div class="text-gray-700 text-sm text-right">
                                <span>応募期限 :{{ $volunteer_offer->start_date }}</span>
                            </div>
                        </div>
                        <h2 class="text-lg text-gray-700 font-semibold">{{ $volunteer_offer->title }}
                        </h2>
                        <p class="mt-4 text-md text-gray-600">
                            {{ Str::limit($volunteer_offer->description, 50, '...') }}
                        </p>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('volunteer_offers.show', $volunteer_offer) }}"
                                class="flex justify-center bg-gradient-to-r from-emerald-500 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-500 hover:to-emerald-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                詳細
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="block mt-3">
                {{ $volunteer_offers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
