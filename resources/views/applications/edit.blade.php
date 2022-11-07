{{-- <x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">求人情報更新</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('volunteer_offers.update', $volunteer_offer) }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    タイトル
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title', $volunteer_offer->title) }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="due_date">
                    募集開始
                </label>
                <input type="date" name="start_date"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="募集開始" value="{{ old('start_date', $volunteer_offer->start_date) }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    詳細
                </label>
                <textarea name="description" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="詳細">{{ old('description', $volunteer_offer->description) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    公開状況
                </label>
                @foreach (App\Models\VolunteerOffer::STATUS_LIST as $value => $name)
                    <input type="radio" name="is_published" value="{{ $value }}" @if ($value == old('is_published', $volunteer_offer->is_published)) checked="checked" @endif required>
                    <label class="text-white mr-2">{{ $name }}</label>
                @endforeach
            </div>
            <input type="submit" value="更新"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout> --}}
