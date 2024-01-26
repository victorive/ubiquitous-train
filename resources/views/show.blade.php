@extends('layouts.app')
@section('title', 'Item')
@section('content')

    <article class="px-4 py-24 mx-auto max-w-7xl">
        <a onclick="history.back()" class="cursor-pointer">
            <svg class="mb-4" xmlns="http://www.w3.org/2000/svg" version="1.0" width="25.000000pt" height="25.000000pt"
                 viewBox="0 0 50.000000 50.000000" preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,50.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                    <path
                        d="M155 456 c-60 -28 -87 -56 -114 -116 -36 -79 -19 -183 42 -249 33 -36 115 -71 167 -71 52 0 134 35 167 71 34 37 63 110 63 159 0 52 -35 134 -71 167 -37 34 -110 63 -159 63 -27 0 -65 -10 -95 -24z m180 -15 c128 -58 164 -223 72 -328 -101 -115 -283 -88 -348 52 -79 171 104 354 276 276z"/>
                    <path
                        d="M160 295 l-44 -45 46 -47 c26 -26 51 -44 54 -40 4 4 -8 23 -26 42 l-34 35 112 0 c68 0 112 4 112 10 0 6 -44 10 -112 10 l-112 0 32 33 c18 18 32 36 32 40 0 16 -18 4 -60 -38z"/>
                </g>
            </svg>
        </a>

        <div class="w-full mx-auto mb-12 text-left md:w-3/4 lg:w-1/2">
            <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 md:text-4xl" itemprop="headline"
                title="{{ucwords($item->name)}}">{{ucwords($item->name)}}
            </h1>

            <div class="flex items-center">
                <img class="object-cover object-center w-full"
                     srcset="data:image/jpeg;base64,{{ $item->images['pc'] }} 1024w,
                                 data:image/jpeg;base64,{{ $item->images['mobile'] }} 768w,
                                 data:image/jpeg;base64,{{ $item->images['tablet'] }} 480w"
                     sizes="(max-width: 1024px) 100vw, (max-width: 768px) 100vw, (max-width: 480px) 100vw"
                     alt="image" src=""/>
            </div>

            <p class="mt-6 mb-2 text-l font-semibold tracking-wider uppercase text-[#000000]">Profile Information</p>

            <div class="flex justify-between"><span><strong>Name:</strong></span><span>{{ ucwords($item->name) }}</span>
            </div>
            <div class="flex justify-between"><span><strong>License:</strong></span><span>{{ $item->license }}</span>
            </div>
            <div class="flex justify-between"><span><strong>WL Status:</strong></span><span>{{ $item->wlStatus }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Aliases:</strong></span><span>{{ implode(', ', $item->aliases) ?: '-' }}</span>
            </div>
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
            <div class="flex justify-between">
                <span><strong>Piercings:</strong></span><span>{{ !empty($item['attributes']['piercings']) ? $item['attributes']['piercings'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Breast Size:</strong></span><span>{{ !empty($item['attributes']['breastSize']) ? $item['attributes']['breastSize'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Breast Type:</strong></span><span>{{ !empty($item['attributes']['breastType']) ? $item['attributes']['breastType'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Orientation:</strong></span><span>{{ !empty($item['attributes']['orientation']) ? $item['attributes']['orientation'] : '-' }}</span>
            </div>

            <br><span>Stats</span>
            <hr>
            <br>
            <div class="flex justify-between">
                <span><strong>Rank:</strong></span><span>{{ !empty($item['attributes']['stats']['rank']) ? $item['attributes']['stats']['rank'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Views:</strong></span><span>{{ !empty($item['attributes']['stats']['views']) ? $item['attributes']['stats']['views'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Rank WL:</strong></span><span>{{ !empty($item['attributes']['stats']['rankWl']) ? $item['attributes']['stats']['rankWl'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Rank Premium:</strong></span><span>{{ !empty($item['attributes']['stats']['rankPremium']) ? $item['attributes']['stats']['rankPremium'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Videos Count:</strong></span><span>{{ !empty($item['attributes']['stats']['videosCount']) ? $item['attributes']['stats']['videosCount'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Subscriptions:</strong></span><span>{{ !empty($item['attributes']['stats']['subscriptions']) ? $item['attributes']['stats']['subscriptions'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Monthly Searches:</strong></span><span>{{ !empty($item['attributes']['stats']['monthlySearches']) ? $item['attributes']['stats']['monthlySearches'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>Premiums Videos Count:</strong></span><span>{{ !empty($item['attributes']['stats']['premiumVideosCount']) ? $item['attributes']['stats']['premiumVideosCount'] : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span><strong>White Label Video Count:</strong></span><span>{{ !empty($item['attributes']['stats']['whiteLabelVideoCount']) ? $item['attributes']['stats']['whiteLabelVideoCount'] : '-' }}</span>
            </div>
            <div class="flex items-center justify-center mx-auto text-center">
                <a href="{{ $item->link }}" target="_blank">
                    <input type="submit"
                           class="w-full sm:w-auto mt-5 bg-[#000000] rounded-lg text-white text-sm text-center align-middle py-2 px-6 leading-relaxed sm:mt-0 cursor-pointer"
                           value="View More">
                </a>
            </div>
        </div>
    </article>
@endsection
