@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <section class="px-6 md:px-12 py-10 mt-[65px] mx-auto">

        <div class="text-center">
            <h2 class="text-3xl font-bold mb-1 tracking-tight text-gray-900 sm:text-4xl">
                Profiles
            </h2>
            <p class="text-sm mb-1 text-gray-900 sm:text-sm">
                Count: {{ $items->total() }}
            </p>
        </div>

        @if($items->count())
            <div
                class="mb-4 mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-16 lg:gap-x-12 gap-y-20">
                @foreach($items as $item)
                    <div class="w-full rounded-lg shadow-lg shadow-gray-500/50 duration-500 hover:scale-105">
                        <a href="{{ url('items/' . $item->id) }}">
                            <img class="object-cover w-full"
                                 srcset="@foreach(collect($item->images) as $deviceType => $image)
                                 @if(isset($image['image']))
                                 data:image/jpeg;base64,{{ $image['image'] }} @if($loop->last)
                                 @else
                                 1024w,
                                 @endif
                                 @else
                                 @if(isset($item->thumbnails[$loop->index], $item->thumbnails[$loop->index]['urls'], $item->thumbnails[$loop->index]['urls'][0]))
                                 {{ $item->thumbnails[$loop->index]['urls'][0] }} @if($loop->last)
                                 768w,
                                 @else
                                 480w,
                                 @endif
                                 @else
                                 {{ asset('no_image.jpg') }} @if($loop->last)
                                 768w,
                                 @else
                                 480w,
                                 @endif
                                 @endif
                                 @endif
                                 @endforeach"
                                 sizes="(max-width: 1024px) 100vw, (max-width: 768px) 100vw, (max-width: 480px) 100vw"
                                 alt="image" src=""/>
                            <div class="px-6 py-4">
                                <h4 class="mb-3 text-xl font-semibold tracking-tight text-gray-700">{{ucwords($item->name)}}</h4>
                                <div class="flex justify-between">
                                    <span><strong>Age:</strong></span><span>{{ !empty($item['attributes']['age']) ? $item['attributes']['age'] : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><strong>Gender:</strong></span><span>{{ !empty($item['attributes']['gender']) ? $item['attributes']['gender'] : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><strong>Tattoos:</strong></span><span>{{ !empty($item['attributes']['tattoos']) ? $item['attributes']['tattoos'] : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><strong>Ethnicity:</strong></span><span>{{ !empty($item['attributes']['ethnicity']) ? $item['attributes']['ethnicity'] : '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span><strong>Hair Colour:</strong></span><span>{{ !empty($item['attributes']['hairColor']) ? $item['attributes']['hairColor'] : '-' }}</span>
                                </div>
                                <div class="flex items-center justify-center mx-auto text-center">
                                    <a href="{{ url('items/' . $item->id) }}">
                                        <input type="submit"
                                               class="w-full sm:w-auto mt-5 bg-[#000000] rounded-lg text-white text-sm text-center align-middle py-2 px-6 leading-relaxed sm:mt-2 cursor-pointer"
                                               value="View More">
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div>
                <h2 class="text-lg font-medium text-center text-gray-500">Nothing here yet!</h2>
            </div>
        @endif

        {{ $items->links() }}
    </section>
@endsection


