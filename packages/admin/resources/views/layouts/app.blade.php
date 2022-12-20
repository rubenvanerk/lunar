<!DOCTYPE html>
<html lang="en"
      class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? 'Hub' }} | {{ config('app.name') }}</title>

    <x-hub::branding.favicon />

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;500;700;900&display=swap"
          rel="stylesheet">

    @livewireTableStyles

    <link href="{{ asset('vendor/lunar/admin-hub/app.css?v=1') }}"
          rel="stylesheet">

    @if ($styles = \Lunar\Hub\LunarHub::styles())
        @foreach ($styles as $asset)
            <link href="{!! $asset->url() !!}"
                  rel="stylesheet">
        @endforeach
    @endif

    <style>
        .filepond--credits {
            display: none !important;
        }
    </style>

    <script defer
            src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

    <script defer
            src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <script defer
            src="https://unpkg.com/alpinejs@3.8.1/dist/cdn.min.js"></script>

    <script>
        JSON.parse(localStorage.getItem('_x_showExpandedMenu')) ?
            document.documentElement.classList.add('app-sidemenu-expanded') :
            document.documentElement.classList.remove('app-sidemenu-expanded');

        document.addEventListener('alpine:init', () => {
            document.documentElement.classList.remove('app-sidemenu-expanded');
        })
    </script>

    @livewireStyles
</head>

<body class="antialiased h-full bg-gray-50 dark:bg-gray-900"
      :class="{ 'dark': darkMode }"
      x-data="{
          showExpandedMenu: $persist(false),
          showMobileMenu: false,
          darkMode: $persist(false),
      }">
    {!! \Lunar\Hub\LunarHub::paymentIcons() !!}

    <div class="flex w-full h-full">
        <div
            class="bg-gray-800 w-64 fixed h-full border-r border-gray-100 dark:bg-gray-900 dark:border-gray-800"
            :class="{
                'w-64': showExpandedMenu,
                'w-20': !showExpandedMenu
            }"
        >
            @include('adminhub::partials.navigation.side-menu')

            <div class="p-4 border-t border-gray-100 shrink-0">
                <p class="text-xs text-center text-gray-500">
                    <span x-cloak x-show="showExpandedMenu">
                        Lunar
                    </span>

                    <x-hub::lunar.version />
                </p>
            </div>

            <button x-on:click="showExpandedMenu = !showExpandedMenu" class="absolute z-50 p-1 -ml-[11px] text-gray-600 bg-white border border-gray-200 rounded left-full bottom-16">
                <span :class="{ '-rotate-180': showExpandedMenu }" class="block">
                    <x-hub::icon ref="chevron-right" class="w-3 h-3" style="solid" />
                </span>
            </button>
        </div>

        <div
            class="grow"
            :class="{
                'lg:pl-64': showExpandedMenu,
                'lg:pl-20': !showExpandedMenu
            }"
        >
            <main class="flex flex-1 overflow-hidden">
                <section class="flex-1 h-full min-w-0 overflow-y-auto lg:order-last">
                    @include('adminhub::partials.navigation.header')
                    <div class="px-4 py-8 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                        @yield('main', $slot)
                    </div>
                </section>

                @if ($menu ?? false)
                    @include('adminhub::partials.navigation.side-menu-nested')
                @endif
            </main>
        </div>
    </div>

    {{-- <div class="flex h-full">
        @include('adminhub::partials.navigation.side-menu')
    </div> --}}
{{--
    <div class="flex h-full">
        @include('adminhub::partials.navigation.side-menu-mobile')

        @include('adminhub::partials.navigation.side-menu')

        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            @include('adminhub::partials.navigation.header-mobile')

            <main class="flex flex-1 overflow-hidden">
                <section class="flex-1 h-full min-w-0 overflow-y-auto lg:order-last">
                    @include('adminhub::partials.navigation.header')

                    <div class="px-4 py-8 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                        @yield('main', $slot)
                    </div>
                </section>

                @yield('menu')

                @if ($menu ?? false)
                    @include('adminhub::partials.navigation.side-menu-nested')
                @endif
            </main>
        </div>
    </div>

    <x-hub::notification />

    @livewire('hub-license')

    @livewireScripts

    @if ($scripts = \Lunar\Hub\LunarHub::scripts())
        @foreach ($scripts as $asset)
            <script src="{!! $asset->url() !!}"></script>
        @endforeach
    @endif

    <script src="{{ asset('vendor/lunar/admin-hub/app.js') }}"></script> --}}
</body>

</html>
