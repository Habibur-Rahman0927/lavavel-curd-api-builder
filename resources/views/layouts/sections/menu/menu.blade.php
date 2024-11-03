<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menu['menu'] as $item)
            <li class="nav-item">
                @if (isset($item['nav-heading']))
                    {!! $item['nav-heading'] !!}
                @elseif (isset($item['submenu']))
                    @if (Auth::user()->hasAnyPermission($item['permission']))
                        @php
                            $isActive = in_array(Route::currentRouteName(), array_column($item['submenu'], 'url'));
                        @endphp
                        <a class="nav-link {{ $isActive ? '' : 'collapsed' }}" data-bs-target="#{{ $item['slug'] }}-nav" data-bs-toggle="collapse" href="#">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['name'] }}</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="{{ $item['slug'] }}-nav" class="nav-content {{ $isActive ? '' : 'collapse' }}" data-bs-parent="#sidebar-nav">
                            @foreach ($item['submenu'] as $subitem)
                                @if (Auth::user()->can($subitem['url']))
                                    <li>
                                        <a href="{{ route($subitem['url']) }}" class="{{ Route::currentRouteName() === $subitem['url'] ? 'active' : '' }}">
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
                            <a class="nav-link {{ Route::currentRouteName() === $item['url'] ? 'active' : 'collapsed' }}" href="{{ route($item['url']) }}">
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
