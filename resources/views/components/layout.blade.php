<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nhân Viên Xuất Sắc 3DS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" crossorigin="anonymous"></script> --}}

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/backend.css')}}">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    @livewireStyles


    <?php /*
    $urlTiny = "https://cdn.tiny.cloud/1/" . config('services.tinymce.key') . "/tinymce/7/tinymce.min.js"
    */ ?>

    {{-- <script src="{{$urlTiny}}" referrerpolicy="origin"></script> --}}

</head>

<body class="px-10">
    <header class="w-full bg-white p-3 flex items-center justify-between" >
        <div>
        <a href="{{route('home')}}">

            <img src="https://drive.3d-smartsolutions.com/tai-ve/b5b2304acc44020e6af508065452a7c02b5e0853dd357cb300a6e0d3a0a58b1e" class="w-60"/>
        </a>
        </div>
        <div>
            <ul class="flex gap-2">

                {{-- <li class="border-r border-black px-2" >{{auth()->user()->name}}</li> --}}
                {{-- <li>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                    <button>Đăng xuất</button>
                    </form>
                </li> --}}

                <div class="dropdown me-3">
                    <button class="btn btn-white dropdown-toggle" href="#" id="menu_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded-circle" style="width:24px;display:inline-block" src="{{ auth()->user()->profile_photo_url }}" alt="avatar" />
                        {{auth()->user()->name}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="menu_dropdown">
                        @if(auth()->user()->type == 1)
                        <a class="dropdown-item" href="{{ route('nhan-vien.edit',['danhSachNhanVien'=>auth()->user()]) }}">Đổi mật khẩu</a>


                        <hr class="dropdown-divider">
                        @endif
                    <!-- Authentication -->
                    <form action="{{route('logout')}}" method="POST" style="padding:4px 16px;">
                        @csrf
                    <button>Đăng xuất</button>
                    </form>


                </div>
        </div>
    </header>
    <div class="w-full flex flex-row items-stretch  pb-10">
        <div class="w-1/6 mb-quet-qr">
            @include('nav')
        </div>
        <div class="w-5/6 p-4 mx-auto">
        {{$slot}}
        </div>

    </div>

    <script src="{{ asset('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
    @stack('scripts')
    <script>
        function toggleMenu() {
            const submenu = document.getElementById('submenu');
            submenu.classList.toggle('hidden');
        }
    </script>
</body>

</html>
