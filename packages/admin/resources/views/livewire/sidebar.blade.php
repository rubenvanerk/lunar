<div>
    <x-hub::menu handle="sidebar"
                 current="{{ request()->route()->getName() }}">
        <ul class="px-2 space-y-4">
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
                            class="text-xs font-semibold text-gray-200 px-3">
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
                                                    class="p-1 text-gray-600">
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
                                                    class="p-1 ml-auto text-white bg-gray-700 shadow-sm border border-gray-900 rounded">
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
                                             class=""
                                             :class="{
                                                 'absolute top-0 left-[calc(100%_+_45px)] shadow-sm z-50 rounded': !
                                                     showExpandedMenu && showSubMenu
                                             }">
                                            <ul
                                                :class="{
                                                    'ml-[21px]': showExpandedMenu &&
                                                        showSubMenu,
                                                    'w-64 p-4': !showExpandedMenu && showSubMenu
                                                }">
                                                @foreach ($section->getItems() as $item)
                                                    <li>
                                                        <a href="{{ route($item->route) }}"
                                                           @class([
                                                               'flex text-sm font-medium border-l py-1 px-[22px]',
                                                               'text-white border-blue-600 font-semibold' => $item->isActive(
                                                                   $component->attributes->get('current')
                                                               ),
                                                               'border-gray-700 text-gray-400 hover:border-gray-600 hover:text-gray-300' => !$item->isActive(
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
