<div>
<div class="dataTables_info">
    Показаны с {{ $paginator->firstItem() }} по {{ $paginator->lastItem() }} из {{ $paginator->total() }} записей
</div>
<div class="dataTables_paginate paging_simple_numbers">
    @if ($paginator->hasPages())
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="paginate_button previous disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span aria-hidden="true">←</span>
                    </li>
                @else
                    <li>
                        <button type="button" class="paginate_button previous" dusk="previousPage" wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">←</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="paginate_button current" wire:key="paginator-page-{{ $page }}" aria-current="page">
                                    <span>{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item" wire:key="paginator-page-{{ $page }}">
                                    <button type="button" class="paginate_button" wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                    <button type="button" class="paginate_button next" wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">
                        →
                    </button>
                    </li>
                @else
                    <li>
                    <a class="paginate_button next disabled">
                        →
                    </a>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
</div>