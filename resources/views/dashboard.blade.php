<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            マイページ - 記事管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('posts.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ➕ 新しい記事を作成
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @forelse($posts as $post)
                        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <h3 class="text-lg font-bold mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                作成日: {{ $post->created_at->format('Y年m月d日') }} | 閲覧数: {{ $post->views }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">
                                {{ Str::limit($post->body, 100) }}
                            </p>
                            <div class="flex gap-3">
                                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    ✏️ 編集
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('削除してもよろしいですか？');">
                                        🗑️ 削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">
                            まだ記事がありません。<a href="{{ route('posts.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">新しい記事を作成</a>してみましょう。
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
