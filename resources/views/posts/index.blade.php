<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      ブログ記事一覧
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @auth
        <a href="{{ route('posts.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">
          新規作成
        </a>
      @endauth

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          @forelse($posts as $post)
            <div class="mb-4 pb-4 border-b">
              <h3 class="text-lg font-bold">
                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                  {{ $post->title }}
                </a>
              </h3>
              <p class="text-sm text-gray-600">
                著者: {{ $post->user->name }} | 閲覧数: {{ $post->views }}
              </p>
            </div>
          @empty
            <p>記事がまだ登録されていません。</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>