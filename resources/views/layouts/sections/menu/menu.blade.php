<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menu['menu'] as $item)
            <li class="nav-item">
                @if (isset($item['nav-heading']))
                    {!! $item['nav-heading'] !!}
                @elseif (isset($item['submenu']))
                    @if (Auth::user()->hasAnyPermission($item['permission']))
                        <a class="nav-link {{ Request::routeIs($item['slug'] . '*') ? '' : 'collapsed' }}" data-bs-target="#{{ $item['slug'] }}-nav" data-bs-toggle="collapse" href="#">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['name'] }}</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="{{ $item['slug'] }}-nav" class="nav-content  {{ Request::routeIs($item['slug'] . '*') ? '' : 'collapse' }}" data-bs-parent="#sidebar-nav">
                            @foreach ($item['submenu'] as $subitem)
                                @if (Auth::user()->can($subitem['url']))
                                    <li>
                                        <a href="{{ route($subitem['url']) }}" class="{{ Request::routeIs($subitem['url']) ? 'active' : '' }}">
                                            <i class="{{ $subitem['icon'] }}"></i>
                                            <span>{{ $subitem['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                             @endforeach
                        </ul>
                    @endif
                @else
                    @if (Auth::user()->hasAnyPermission($item['permission']))
                        @if (Auth::user()->can($item['url']))
                            <a class="nav-link {{ Request::routeIs($item['slug'] . '*') ? '' : 'collapsed' }}" href="{{ route($item['url']) }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ $item['name'] }}</span>
                            </a>
                        @endif
                    @endif
                @endif
            </li>
        @endforeach
    </ul>
</aside>
