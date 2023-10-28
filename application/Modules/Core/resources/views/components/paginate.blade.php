<?php
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-rounded">
        <li class="page-item {{ ($paginator->currentPage() == 1) ? ' active' : '' }}" style="margin: 6px">
            <a class="page-link" href="{{ $paginator->withQueryString()->url(1) }}">اولین صفحه </a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                    $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
                ?>
            @if ($from < $i && $i < $to)
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}" style="margin: 6px">
                    <a class="page-link" href=" {{ $paginator->withQueryString()->url($i) }}" >{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' active' : '' }}" style="margin: 6px">
            <a class="page-link" href=" {{ $paginator->withQueryString()->url($paginator->lastPage()) }}">اخرین صفحه</a>
        </li>
    </ul>
</nav>
@endif
