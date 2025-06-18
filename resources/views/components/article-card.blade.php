<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('articles.show', ['article' => $article->slug]) }}" class="block">
        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
        
        <div class="p-4">
            <div class="flex items-center text-xs text-gray-500 mb-2">
                <span>{{ $article->created_at->format('j M Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ $article->category->name }}</span>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-800 line-clamp-2 h-14">{{ $article->title }}</h3>
            
            <p class="mt-2 text-gray-600 line-clamp-3 h-18">
                {{ Str::limit(strip_tags($article->content), 150) }}
            </p>
            
            @if($article->tags->count() > 0)
                <div class="mt-3 flex flex-wrap gap-1">
                    @foreach($article->tags->take(3) as $tag)
                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </a>
</div>