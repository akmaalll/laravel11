<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{ now()->year }}&copy;</span>
            <a href="{{ config('app.url') }}" target="_blank" class="text-gray-800 text-hover-primary">
                {{ config('app.name', 'UMI - FIKIR') }}
            </a>
        </div>
        <!--end::Copyright-->

        @if (config('app.footer_links'))
            <!--begin::Menu-->
            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                @foreach (config('app.footer_links') as $link)
                    <li class="menu-item">
                        <a href="{{ $link['url'] }}" target="_blank" class="menu-link px-2">
                            {{ $link['text'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <!--end::Menu-->
        @endif
    </div>
    <!--end::Container-->
</div>
