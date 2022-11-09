<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-orange-100 shadow-md rounded-md">
        <h2 class="text-center text-lg text-gray-700 font-bold pt-6 tracking-widest">経歴等の編集</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('applications.update', $application) }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PUT')
            {{-- <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    タイトル
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title', $application->title) }}">
            </div> 
            <div class="mb-4">
                <label class="block text-white mb-2" for="due_date">
                    募集開始
                </label>
                <input type="date" name="start_date"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="募集開始" value="{{ old('start_date', $application->start_date) }}">
            </div>--}}
            <div class="mb-4">
                {{-- <label class="block text-white mb-2" for="career">
                    詳細
                </label> --}}
                <textarea name="career" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-orange-800 focus:ring focus:ring-orange-600 w-full py-2 px-3"
                    required placeholder="経歴、希望する活動内容や場所等を記載してください">{{ old('career', $application->career) }}</textarea>
            </div>
            {{-- <div class="mb-4">
                <label class="block text-white mb-2" for="career">
                    公開状況
                </label>
                @foreach (App\Models\VolunteerOffer::STATUS_LIST as $value => $name)
                    <input type="radio" name="is_published" value="{{ $value }}" @if ($value == old('is_published', $application->is_published)) checked="checked" @endif required>
                    <label class="text-white mr-2">{{ $name }}</label>
                @endforeach
            </div> --}}
            <input type="submit" value="更新し、公開"
                class="w-full flex justify-center bg-gradient-to-r from-emerald-300 to-emerald-600 hover:bg-gradient-to-l hover:from-emerald-600 hover:to-emerald-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout>
