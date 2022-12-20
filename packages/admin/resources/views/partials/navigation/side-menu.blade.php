<div class="flex flex-col h-full">
    <a href="{{ route('hub.index') }}" class="flex items-center w-full h-16 px-4">
        <x-hub::branding.logo x-cloak x-show="showExpandedMenu" />
        <x-hub::branding.logo x-cloak x-show="!showExpandedMenu" iconOnly />
    </a>
    <div class="grow h-full order-t border-gray-100 dark:border-gray-800 py-4">
        @livewire('sidebar')
    </div>
    @if (Auth::user()->can('settings'))
        <div class="px-2 py-2 border-t border-gray-100">
            <a href="{{ route('hub.settings') }}"
               @class([
                   'menu-link group',
                   'menu-link--active' => Str::contains(request()->url(), 'settings'),
                   'menu-link--inactive !text-gray-700' => !Str::contains(
                       request()->url(),
                       'settings'
                   ),
               ])
               :class="{ 'group justify-center': !showExpandedMenu }">
                <span x-cloak
                      :class="{ 'mx-auto': !showExpandedMenu }">
                    {!! Lunar\Hub\LunarHub::icon('cog', 'w-5 h-5') !!}
                </span>

                <span x-cloak
                      x-show="showExpandedMenu"
                      class="font-medium group-hover:!block"
                      :class="{
                          'absolute top-1/2 -translate-y-1/2 left-full ml-2 bg-blue-700 z-50 text-white rounded py-1.5 px-3 text-xs':
                              !showExpandedMenu,
                          'text-sm': showExpandedMenu
                      }">
                    {{ __('adminhub::global.settings') }}
                </span>
            </a>
        </div>
    @endif
    {{-- <div class="relative flex flex-col justify-between bg-white border-r border-gray-100 dark:bg-gray-900 dark:border-gray-800 app-sidemenu"
         :class="{
             'w-64': showExpandedMenu,
             'w-20': !showExpandedMenu
         }">
        <div class="flex-1">
            <a href="{{ route('hub.index') }}"
    class="flex items-center w-full h-16 px-4">
    <x-hub::branding.logo x-cloak x-show="showExpandedMenu" />
    <x-hub::branding.logo x-cloak x-show="!showExpandedMenu" iconOnly />
    </a>

    <div class="w-full px-2 py-4 border-t border-gray-100 dark:border-gray-800">
        @livewire('sidebar')
    </div>
</div>


</div> --}}
</div>
