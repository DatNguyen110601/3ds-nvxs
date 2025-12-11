
{{-- <nav aria-label="breadcrumb">
    <ol class="flex items-center gap-2 mb-2 font-semibold text-lg text-gray-500">
        @foreach ($list as $link=>$value)

            <li class="breadcrumb-item after:content-[''] last:after:content-['']">
                <a href="{{$link}}">{{$value}} </a>
            </li>
        @endforeach
    </ol>
  </nav> --}}


  <nav aria-label="breadcrumb">
    <ol class="flex items-center gap-2 mb-2 font-semibold text-lg text-gray-500">

        @foreach ($list as $link => $value)
            {{-- Kiểm tra mục cuối --}}
            @if ($loop->last)
                <li class="text-gray-700">
                    {{ $value }}
                </li>
            @else
                <li>
                    <a href="{{ $link }}" class="hover:text-gray-700">
                        {{ $value }}
                    </a>
                    <span class="mx-1">/</span>
                </li>
            @endif
        @endforeach

    </ol>
</nav>
