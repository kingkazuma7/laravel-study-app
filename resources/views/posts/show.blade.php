<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $post->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <p class="text-sm text-gray-600 mb-4">
            著者: {{ $post->user->name }} | 閲覧数: {{ $post->views }}
          </p>

          <div class="prose mb-6">
            {!! nl2br(e($post->body)) !!}
          </div>

          <div class="flex gap-2">
            @auth
              @if(auth()->id() === $post->user_id)
                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-blue-600 text-white rounded">編集</a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('削除しますか？')" class="px-4 py-2 bg-red-600 text-white rounded">削除</button>
                </form>
              @endif
            @endauth
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>