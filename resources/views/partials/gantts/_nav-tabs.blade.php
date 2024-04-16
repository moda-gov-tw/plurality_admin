<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
    @foreach($regions as $key=>$region)
        <li class="nav-item">
            <a class="nav-link text-active-primary @if($key==0) active @endif" data-bs-toggle="tab" href="#region_{{$region['id']}}">{{$region['name']}}</a>
        </li>
    @endforeach
</ul>