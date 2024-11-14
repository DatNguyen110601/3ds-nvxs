
<nav aria-label="breadcrumb">
    <ol class="flex items-center gap-2 mb-2 font-semibold text-gray-500">
        @foreach ($list as $link=>$value)

            <li class="breadcrumb-item after:content-['»'] last:after:content-['']">
                <a href="{{$link}}">{{$value}} </a>
            </li>
        @endforeach
    </ol>
  </nav>
