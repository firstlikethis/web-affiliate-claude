@extends('layouts.app')

@section('title', $article->title)

@section('meta_description', Str::limit(strip_tags($article->content), 160))

@section('meta_keywords', $article->tags->pluck('name')->join(', '))

@section('content')
    <div class="container mx-auto px-4 py-8">
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Article Header -->
            <header class="relative">
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-64 md:h-96 object-cover">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                    <div class="p-6 text-white">
                        <h1 class="text-2xl md:text-4xl font-bold mb-2">{{ $article->title }}</h1>
                        
                        <div class="flex flex-wrap items-center text-sm gap-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $article->created_at->format('j M Y') }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ $article->category->name }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $article->view_count }} ครั้ง</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $article->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Article Content -->
            <div class="p-6">
                <!-- Tags -->
                @if($article->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($article->tags as $tag)
                            <a href="{{ route('tag.show', ['tag' => $tag->slug]) }}" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <!-- Article Body -->
                <div class="prose prose-lg max-w-none prose-blue prose-img:rounded-lg prose-headings:font-bold prose-a:text-blue-600">
                    {!! $article->content !!}
                </div>
                
                <!-- Share Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">แชร์บทความนี้</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="bg-sky-500 text-white p-2 rounded-full hover:bg-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" class="bg-blue-700 text-white p-2 rounded-full hover:bg-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                            </svg>
                        </a>
                        <a href="https://line.me/R/msg/text/?{{ urlencode($article->title) }}%0D%0A{{ urlencode(request()->url()) }}" target="_blank" class="bg-green-500 text-white p-2 rounded-full hover:bg-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 10.304c0-5.369-5.383-9.738-12-9.738-6.616 0-12 4.369-12 9.738 0 4.819 4.588 8.856 10.784 9.622.418.091.793.274.965.493.148.19.124.473.121.755l-.015.652c-.043.518-.368 2.073 1.006 1.131 1.315-.899 7.021-4.132 9.569-7.053 1.74-1.92 2.57-3.878 2.57-5.6z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </article>
        
        <!-- Related Articles -->
        @if($relatedArticles->isNotEmpty())
            <section class="mt-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">บทความที่เกี่ยวข้อง</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $relatedArticle)
                        @include('components.article-card', ['article' => $relatedArticle])
                    @endforeach
                </div>
            </section>
        @endif
        
        <!-- Mentioned Products -->
        @if(isset($mentionedProducts) && $mentionedProducts->isNotEmpty())
            <section class="mt-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">สินค้าที่กล่าวถึงในบทความ</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($mentionedProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection