<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      記事編集
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
              <label class="block text-sm font-medium mb-2">タイトル</label>
              <input type="text" name="title" required class="w-full px-3 py-2 border rounded @error('title') border-red-600 @enderror" value="{{ old('title', $post->title) }}">
              @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium mb-2">本文</label>
              <textarea name="body" required class="w-full px-3 py-2 border rounded @error('body') border-red-600 @enderror">{{ old('body', $post->body) }}</textarea>
              @error('body')
                <span class="text-red-600 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">更新</button>
            <a href="{{ route('posts.show', $post) }}" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded">キャンセル</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
