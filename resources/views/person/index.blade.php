<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Person 一覧
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-semibold mb-4">Person Code で検索</h3>
          <form method="GET" action="{{ route('person.index') }}" class="flex gap-2">
            <input
              type="text"
              name="person_code"
              placeholder="Person Code を入力"
              value="{{ request('person_code') }}"
              class="px-4 py-2 border rounded"
            >
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              検索
            </button>
            @if(request('person_code'))
              <a href="{{ route('person.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                リセット
              </a>
            @endif
          </form>
        </div>
      </div>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 text-left">Person Code</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Mail</th>
                <th class="px-4 py-2 text-left">Age</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr class="border-b hover:bg-gray-50">
                  <td class="px-4 py-2 font-semibold">{{ $item->person_code }}</td>
                  <td class="px-4 py-2">{{ $item->name }}</td>
                  <td class="px-4 py-2">{{ $item->mail }}</td>
                  <td class="px-4 py-2">{{ $item->age }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-4 py-2 text-center text-gray-500">データがありません</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
