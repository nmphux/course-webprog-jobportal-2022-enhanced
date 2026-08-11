<?php
/**
 * Pagination Partial
 * Data: $pagination (array with page, total_pages, base_url), $filters (current query params)
 */
if (($pagination['total_pages'] ?? 1) <= 1) return;

$current = (int)($pagination['page'] ?? 1);
$total   = (int)($pagination['total_pages'] ?? 1);
$base    = $pagination['base_url'] ?? '';

// Build query string from filters, excluding 'page'
$query_params = $filters ?? [];
unset($query_params['page']);

function pagination_url($page, $base, $query_params) {
    $query_params['page'] = $page;
    $qs = http_build_query($query_params);
    return $base . ($qs ? '?' . $qs : '');
}

// Calculate range with ellipsis
$range = 2;
$start = max(1, $current - $range);
$end   = min($total, $current + $range);
?>
<nav aria-label="<?= __('pagination.label') ?>" style="margin-top: 2rem;">
    <ul class="pagination justify-content-center" style="flex-wrap: wrap;">
        <li class="page-item<?= $current <= 1 ? ' disabled' : '' ?>">
            <a class="page-link" href="<?= $current > 1 ? e(pagination_url($current - 1, $base, $query_params)) : '#' ?>" aria-label="<?= __('pagination.previous') ?>">
                &laquo; <?= __('pagination.previous') ?>
            </a>
        </li>

        <?php if ($start > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?= e(pagination_url(1, $base, $query_params)) ?>">1</a>
            </li>
            <?php if ($start > 2): ?>
                <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item<?= $i === $current ? ' active' : '' ?>">
                <a class="page-link" href="<?= e(pagination_url($i, $base, $query_params)) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($end < $total): ?>
            <?php if ($end < $total - 1): ?>
                <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link" href="<?= e(pagination_url($total, $base, $query_params)) ?>"><?= $total ?></a>
            </li>
        <?php endif; ?>

        <li class="page-item<?= $current >= $total ? ' disabled' : '' ?>">
            <a class="page-link" href="<?= $current < $total ? e(pagination_url($current + 1, $base, $query_params)) : '#' ?>" aria-label="<?= __('pagination.next') ?>">
                <?= __('pagination.next') ?> &raquo;
            </a>
        </li>
    </ul>
</nav>
