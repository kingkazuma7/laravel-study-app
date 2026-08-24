<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $person->name }} の詳細
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">基本情報</h3>
          <table class="w-full border-collapse">
            <tr class="border-b">
              <th class="px-4 py-2 text-left font-semibold">Person Code</th>
              <td class="px-4 py-2">{{ $person->person_code }}</td>
            </tr>
            <tr class="border-b">
              <th class="px-4 py-2 text-left font-semibold">Name</th>
              <td class="px-4 py-2">{{ $person->name }}</td>
            </tr>
            <tr class="border-b">
              <th class="px-4 py-2 text-left font-semibold">Mail</th>
              <td class="px-4 py-2">{{ $person->mail }}</td>
            </tr>
            <tr class="border-b">
              <th class="px-4 py-2 text-left font-semibold">Age</th>
              <td class="px-4 py-2">{{ $person->age }}</td>
            </tr>
          </table>
          <a href="{{ route('person.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            一覧に戻る
          </a>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">コメント（{{ $person->comments()->count() }}件）</h3>
          @forelse ($person->comments as $comment)
            <div class="border-b pb-4 mb-4">
              <p class="text-sm text-gray-500">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
              <p>{{ $comment->body }}</p>
            </div>
          @empty
            <p class="text-gray-500">コメントがありません</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
