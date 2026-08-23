<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Query Builder で取得
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p style="color: #6B7280; margin-bottom: 2rem;">
                        SQL ベースのアプローチ。JOIN を手動で指定して、SQL に近い思考で書く。<br>
                        <code style="background: #F3F4F6; padding: 0.25rem 0.5rem; border-radius: 4px;">DB::table('posts')->join(...)->select(...)->get()</code>
                    </p>

                    <div style="display: grid; gap: 1.5rem;">
                        @forelse($posts as $post)
                            <div style="border: 1px solid #E5E7EB; padding: 1.5rem; border-radius: 8px; background: #FAFAFA;">
                                <h3 style="color: #1F2937; font-size: 1.25rem; margin: 0 0 0.5rem 0;">{{ $post->title }}</h3>
                                <p style="color: #6B7280; margin: 0; font-size: 0.9rem;">著者: <strong>{{ $post->author }}</strong></p>
                                <p style="color: #6B7280; margin: 0.5rem 0 0 0; font-size: 0.875rem;">
                                    投稿日: <strong>{{ $post->created_at }}</strong>
                                </p>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 3rem; background: #F9FAFB; border-radius: 8px; border: 1px solid #E5E7EB;">
                                <p style="color: #6B7280; margin: 0;">データがありません</p>
                            </div>
                        @endforelse
                    </div>

                    <div style="margin-top: 2rem; padding: 1.5rem; background: #F0FDF4; border: 2px solid #10B981; border-radius: 8px;">
                        <h4 style="color: #10B981; margin-top: 0; margin-bottom: 1rem;">✅ Query Builder の特徴</h4>
                        <ul style="margin: 0; padding-left: 1.5rem; color: #1F2937; line-height: 1.8;">
                            <li><code style="background: #DCFCE7; padding: 0.125rem 0.375rem; border-radius: 4px;">join()</code> で SQL の JOIN を明示的に記述</li>
                            <li><code style="background: #DCFCE7; padding: 0.125rem 0.375rem; border-radius: 4px;">select()</code> で必要なカラムのみ取得</li>
                            <li>1 回のクエリで結果を取得（N+1 問題がない）</li>
                            <li>結果は stdClass オブジェクト（モデルメソッドなし）</li>
                        </ul>
                    </div>

                    <div style="margin-top: 2rem;">
                        <a href="{{ url('/demo/orm') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            ← 📦 Eloquent ORM 版を見る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>