<style>
    a:hover{
        color: rgb(185 28 28);

    }
</style>
<nav class="py-3 pr-2">
    <ul class="gap-2 text-lg">
        {{-- @can('view_danh_muc_thang_nam') --}}
        <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('danh-muc-thang-nam.index')}}" class="{{request()->routeIs('danh-muc-thang-nam.*')?'text-red-700':'text-gray-600'}}">Danh mục tháng năm</a>
        </li>
        {{-- @endcan --}}

        <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('nhan-vien.index')}}" class="{{request()->routeIs('nhan-vien.*')?'text-red-700':'text-gray-600'}}">Nhân viên</a>
        </li>
        <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('tieu-chi-nhan-vien.index')}}" class="{{request()->routeIs('tieu-chi-nhan-vien.*')?'text-red-700':'text-gray-600'}}">Danh sách tiêu chí</a>
        </li>
        <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('tieu-chi-theo-thang.index')}}" class="{{request()->routeIs('tieu-chi-theo-thang.*')?'text-red-700':'text-gray-600'}}">Tiêu chí theo tháng</a>
        </li>
        <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('nhan-vien-xuat-sac.index')}}" class="{{request()->routeIs('nhan-vien-xuat-sac.*')?'text-red-700':'text-gray-600'}}">Nhân viên xuất sắc</a>
        </li>
        {{-- <li class="px-4 py-3 font-semibold rounded-3xl hover:bg-gray-200">
            <a href="{{route('diem-thang.index')}}" class="{{request()->routeIs('diem-thang.*')?'text-red-700':'text-gray-600'}}">Điểm tháng</a>
        </li> --}}
    </ul>
</nav>
