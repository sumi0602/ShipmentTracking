<?php $__env->startSection('title', 'Shipments'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    
    <div class="page-header">
        <p class="page-header__eyebrow">Dashboard</p>
        <h1 class="page-header__title">Shipments</h1>
        <p class="page-header__sub">Track and manage all your active shipments in one place.</p>
    </div>

    
    <?php
        $total     = $shipments->total();
        $pending   = \App\Models\Shipment::where('status', 'Pending')->count();
        $inTransit = \App\Models\Shipment::where('status', 'In Transit')->count();
        $delivered = \App\Models\Shipment::where('status', 'Delivered')->count();
    ?>

    <div class="stats">
        <div class="stat">
            <p class="stat__label">Total</p>
            <p class="stat__value"><?php echo e(\App\Models\Shipment::count()); ?></p>
        </div>
        <div class="stat">
            <p class="stat__label">Pending</p>
            <p class="stat__value" style="color:var(--amber)"><?php echo e($pending); ?></p>
        </div>
        <div class="stat">
            <p class="stat__label">In Transit</p>
            <p class="stat__value" style="color:var(--blue)"><?php echo e($inTransit); ?></p>
        </div>
        <div class="stat">
            <p class="stat__label">Delivered</p>
            <p class="stat__value" style="color:var(--green)"><?php echo e($delivered); ?></p>
        </div>
    </div>

    
    <form action="<?php echo e(route('shipments.index')); ?>" method="GET" class="search-form" role="search">
        <input
            type="search"
            name="search"
            class="search-input"
            placeholder="Search by tracking number…"
            value="<?php echo e($search); ?>"
            aria-label="Search shipments by tracking number"
            autocomplete="off"
        />
        <button type="submit" class="btn btn--primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Search
        </button>
        <?php if($search): ?>
            <a href="<?php echo e(route('shipments.index')); ?>" class="btn btn--ghost">Clear</a>
        <?php endif; ?>
    </form>

    
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Tracking #</th>
                        <th scope="col">Receiver</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:60px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="td-track"><?php echo e($shipment->tracking_number); ?></td>
                            <td class="td-name"><?php echo e($shipment->receiver_name); ?></td>
                            <td class="td-city"><?php echo e($shipment->destination_city); ?></td>
                            <td>
                                <span class="badge badge--<?php echo e(Str::slug($shipment->status === 'In Transit' ? 'transit' : $shipment->status)); ?>">
                                    <?php echo e($shipment->status); ?>

                                </span>
                            </td>
                            <td class="td-date">
                                <?php echo e($shipment->created_at->format('d M Y')); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('shipments.show', $shipment)); ?>" class="btn btn--ghost" style="padding:6px 12px; font-size:.8125rem;">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <p class="empty__icon">📦</p>
                                    <p class="empty__title">No shipments found</p>
                                    <p class="empty__text">
                                        <?php if($search): ?>
                                            No results for "<strong><?php echo e($search); ?></strong>". Try a different tracking number.
                                        <?php else: ?>
                                            No shipments have been created yet.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($shipments->hasPages()): ?>
            <div class="pagination">
                <span>
                    Showing <?php echo e($shipments->firstItem()); ?>–<?php echo e($shipments->lastItem()); ?>

                    of <?php echo e($shipments->total()); ?> shipments
                </span>
                <div class="pagination__links">
                    <?php echo e($shipments->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\shipment-tracker\resources\views/shipments/index.blade.php ENDPATH**/ ?>