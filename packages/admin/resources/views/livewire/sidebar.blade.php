<div>
    <x-hub::menu handle="sidebar"
                 current="{{ request()->route()->getName() }}">
        <ul class="px-2 space-y-2">
            @foreach ($component->items as $item)
                <li class="relative">
                    <a href="{{ route($item->route) }}"
                       @class([
                           'menu-link group',
                           'menu-link--active' => $item->isActive(
                               $component->attributes->get('current')
                           ),
                           'menu-link--inactive' => !$item->isActive(
                               $component->attributes->get('current')
                           ),
                       ])>
                        <span x-cloak
                            class="menu-link__icon"
                              :class="{ 'mx-auto': !showExpandedMenu }">
                            {!! $item->renderIcon('w-5 h-5') !!}
                        </span>

                        <span x-cloak
                              x-show="showExpandedMenu"
                              class="text-sm"
                              :class="{
                                  'absolute left-[calc(100%_+_4px)] m-auto bg-black z-50 text-white rounded py-1.5 px-3 group-hover:!block':
                                      !showExpandedMenu,
                              }">
                            {{ $item->name }}
                        </span>
                    </a>
                </li>
            @endforeach

            @foreach ($component->groups as $group)
                <li class="relative">
                    <header x-cloak
                            x-show="showExpandedMenu"
                            class="text-sm font-semibold text-gray-600">
                        {{ $group->name }}
                    </header>

                    @if (count($group->getItems()))
                        <ul class="mt-1 space-y-1">
                            @foreach ($group->getItems() as $item)
                                <li class="relative">
                                    <a href="{{ route($item->route) }}"
                                       @class([
                                           'menu-link group',
                                           'menu-link--active' => $item->isActive(
                                               $component->attributes->get('current')
                                           ),
                                           'menu-link--inactive' => !$item->isActive(
                                               $component->attributes->get('current')
                                           ),
                                       ])>
                                        <span x-cloak
                                              class="menu-link__icon"
                                              :class="{ 'mx-auto': !showExpandedMenu }">
                                            {!! $item->renderIcon('w-5 h-5') !!}
                                        </span>

                                        <span x-cloak
                                              x-show="showExpandedMenu"
                                              class="text-sm font-medium"
                                              :class="{
                                                  'absolute left-[calc(100%_+_4px)] m-auto bg-black z-75 text-white rounded py-1.5 px-3 group-hover:!block':
                                                      !showExpandedMenu,
                                              }">
                                            {{ $item->name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if (count($group->getSections()))
                        <ul x-cloak
                            class="mt-1 space-y-1">
                            @foreach ($group->getSections() as $section)
                                <li x-data="{
                                    showSubMenu: false,
                                    hasActiveItem: {{ $section->hasActive($component->attributes->get('current')) ? 'true' : 'false' }},
                                    init() {
                                        this.showSubMenu = (showExpandedMenu && this.hasActiveItem) ? true : this.showSubMenu
                                        this.$watch('showExpandedMenu', (isExpanded) => this.showSubMenu = (isExpanded && this.hasActiveItem) ? true : this.showSubMenu)
                                    },
                                }"
                                    class="relative">
                                    @if (count($section->getItems()))
                                        <span class="absolute z-10 top-0 left-[calc(100%_+_4px)]">
                                            <button x-cloak
                                                    x-show="!showExpandedMenu"
                                                    x-on:click.prevent="!showExpandedMenu && (showSubMenu = !showSubMenu)"
                                                    class="p-1 text-gray-600 bg-white border border-gray-200 rounded">
                                                <x-hub::icon ref="menu"
                                                             class="w-3 h-3" />
                                            </button>
                                        </span>
                                    @endif

                                    <a href="{{ route($section->route) }}"
                                       @class([
                                           'menu-link group',
                                           'menu-link--active' => $section->isActive(
                                               $component->attributes->get('current')
                                           ),
                                           'menu-link--inactive' => !$section->isActive(
                                               $component->attributes->get('current')
                                           ),
                                       ])>
                                        <span x-cloak
                                              class="menu-link__icon"
                                              :class="{ 'mx-auto': !showExpandedMenu }">
                                            {!! $section->renderIcon('w-5 h-5') !!}
                                        </span>

                                        <span x-cloak
                                              x-show="showExpandedMenu"
                                              class="text-sm font-medium"
                                              :class="{
                                                  'absolute left-[calc(100%_+_4px)] m-auto bg-black z-50 text-white rounded py-1.5 px-3 group-hover:!block':
                                                      !showExpandedMenu,
                                              }">
                                            {{ $section->name }}
                                        </span>

                                        @if (count($section->getItems()))
                                            <button x-cloak
                                                    x-show="showExpandedMenu"
                                                    x-on:click.prevent="showSubMenu = !showSubMenu"
                                                    class="p-1 ml-auto text-gray-600 bg-white border border-gray-200 rounded">
                                                <span :class="{ '-rotate-180': showSubMenu }"
                                                      class="block transition">
                                                    <x-hub::icon ref="chevron-down"
                                                                 class="w-3 h-3" />
                                                </span>
                                            </button>
                                        @endif
                                    </a>

                                    @if (count($section->getItems()))
                                        <div x-show="showSubMenu"
                                             class="bg-white"
                                             :class="{
                                                 'absolute top-0 left-[calc(100%_+_40px)] shadow-sm z-50 rounded': !
                                                     showExpandedMenu && showSubMenu
                                             }">
                                            <ul class="space-y-1"
                                                :class="{
                                                    'border-l border-gray-100 ml-[18px] pl-[18px] mt-1': showExpandedMenu &&
                                                        showSubMenu,
                                                    'w-64 p-4': !showExpandedMenu && showSubMenu
                                                }">
                                                @foreach ($section->getItems() as $item)
                                                    <li>
                                                        <a href="{{ route($item->route) }}"
                                                           @class([
                                                               'flex text-sm font-medium',
                                                               'text-blue-600 hover:text-blue-500' => $item->isActive(
                                                                   $component->attributes->get('current')
                                                               ),
                                                               'text-gray-500 hover:text-blue-600' => !$item->isActive(
                                                                   $component->attributes->get('current')
                                                               ),
                                                           ])>
                                                            {{ $item->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </x-hub::menu>
</div>
