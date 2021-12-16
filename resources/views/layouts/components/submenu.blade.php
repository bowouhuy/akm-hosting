<ul class="menu-content">
    @foreach($menu as $submenu)
        <li class="{{ (request()->is($submenu->url)) ? 'active' : '' }}">
            <a href="{{ $submenu->url }}">
                <i class="{{ isset($submenu->icon) ? $submenu->icon : "" }}"></i>
                <span class="menu-title" >{{ $submenu->name }}</span>
            </a>
            @if (isset($submenu->submenu))
                @include('layouts/components/submenu', ['menu' => $submenu->submenu])
            @endif
        </li>
    @endforeach
</ul>