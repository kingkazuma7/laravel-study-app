<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Eloquent ORM で取得
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p style="color: #6B7280; margin-bottom: 2rem;">
                        Post モデルを使ったオブジェクト指向アプローチ。<br>
                        <code style="background: #F3F4F6; padding: 0.25rem 0.5rem; border-radius: 4px;">Post::where(...)->with('user')->get()</code>
                    </p>

                    <div style="display: grid; gap: 1.5rem;">
                        @forelse($posts as $post)
                            <div style="border: 1px solid #E5E7EB; padding: 1.5rem; border-radius: 8px; background: #FAFAFA;">
                                <h3 style="color: #1F2937; font-size: 1.25rem; margin: 0 0 0.5rem 0;">{{ $post->title }}</h3>
                                <p style="color: #6B7280; margin: 0; font-size: 0.9rem;">著者: <strong>{{ $post->user->name }}</strong></p>
                                <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.875rem;">
                                    投稿日: <strong>{{ $post->created_at->format('Y年m月d日') }}</strong>
                                </p>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 3rem; background: #F9FAFB; border-radius: 8px; border: 1px solid #E5E7EB;">
                                <p style="color: #6B7280; margin: 0;">データがありません</p>
                            </div>
                        @endforelse
                    </div>

                    <div style="margin-top: 2rem; padding: 1.5rem; background: #F0F9FF; border: 2px solid #3B82F6; border-radius: 8px;">
                        <h4 style="color: #3B82F6; margin-top: 0; margin-bottom: 1rem;">💡 Eloquent ORM の特徴</h4>
                        <ul style="margin: 0; padding-left: 1.5rem; color: #1F2937; line-height: 1.8;">
                            <li><code style="background: #E0F2FE; padding: 0.125rem 0.375rem; border-radius: 4px;">with('user')</code> で著者情報を自動読み込み</li>
                            <li>モデルメソッドが使える（<code style="background: #E0F2FE; padding: 0.125rem 0.375rem; border-radius: 4px;">$post->created_at->format()</code> など）</li>
                            <li>オブジェクト指向で直感的に書ける</li>
                        </ul>
                    </div>

                    <div style="margin-top: 2rem;">
                        <a href="{{ url('/demo/querybuilder') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            📋 Query Builder 版を見る →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
