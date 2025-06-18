<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('redirect.affiliate', ['product' => $product->slug]) }}" target="_blank" class="block">
        <div class="relative">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            
            @if($product->discount_price)
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                </div>
            @endif
            
            <div class="absolute top-2 right-2 {{ $product->platform === 'shopee' ? 'bg-orange-500' : 'bg-red-600' }} text-white text-xs font-bold px-2 py-1 rounded">
                {{ $product->platform === 'shopee' ? 'Shopee' : 'Lazada' }}
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 line-clamp-2 h-14">{{ $product->name }}</h3>
            
            <div class="mt-2 flex items-center">
                @if($product->discount_price)
                    <span class="text-lg font-bold text-red-600">฿{{ number_format($product->discount_price, 2) }}</span>
                    <span class="ml-2 text-sm text-gray-500 line-through">฿{{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-lg font-bold text-gray-800">฿{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            
            @if($product->tags->count() > 0)
                <div class="mt-3 flex flex-wrap gap-1">
                    @foreach($product->tags->take(3) as $tag)
                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </a>
</div>