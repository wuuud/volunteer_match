<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">スカウト情報作成</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('applications.store') }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            {{-- <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    概要
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="端的にボランティア内容を記載してください" value="{{ old('title') }}">
            </div> --}}
            <div class="mb-4">
                <label class="block text-white mb-2" for="career">
                    希望する活動や経歴等
                </label>
                <textarea name="career" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="活動内容や場所等の詳細を記載してください">{{ old('career') }}</textarea>
            </div>
            {{-- <div class="mb-4">
                @foreach (App\Models\VolunteerOffer::STATUS_LIST as $value => $name)
                    <input type="radio" name="is_published" value="{{ $value }}" required>
                    <label class="text-white mr-2">{{ $name }}</label>
                @endforeach
            </div> --}}
            <input type="submit" value="登録"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout> 
