<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Person 一覧
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Mail</th>
                <th class="px-4 py-2 text-left">Age</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr class="border-b hover:bg-gray-50">
                  <td class="px-4 py-2">{{ $item->name }}</td>
                  <td class="px-4 py-2">{{ $item->mail }}</td>
                  <td class="px-4 py-2">{{ $item->age }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="px-4 py-2 text-center text-gray-500">データがありません</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
