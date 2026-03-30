<?php $__env->startSection('title', 'Shipment ' . $shipment->tracking_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

    
    <a href="<?php echo e(route('shipments.index')); ?>" class="back-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m15 18-6-6 6-6"/></svg>
        All Shipments
    </a>

    
    <div class="page-header">
        <p class="page-header__eyebrow">Shipment Details</p>
        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap">
            <h1 class="page-header__title" style="font-size:clamp(1.5rem,3vw,2rem)">
                <?php echo e($shipment->tracking_number); ?>

            </h1>
            <span class="badge badge--<?php echo e($shipment->status === 'In Transit' ? 'transit' : Str::slug($shipment->status)); ?>"
                  style="font-size:.8125rem; padding:5px 14px">
                <?php echo e($shipment->status); ?>

            </span>
        </div>
        <p class="page-header__sub">Shipped on <?php echo e($shipment->created_at->format('l, d F Y')); ?></p>
    </div>

    
    <div class="detail-grid">

        
        <div class="detail-section">
            <h2 class="detail-section__title">Sender Information</h2>
            <div class="detail-row">
                <span class="detail-row__label">Name</span>
                <span class="detail-row__value"><?php echo e($shipment->sender_name); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Address</span>
                <span class="detail-row__value" style="white-space:pre-line"><?php echo e($shipment->sender_address); ?></span>
            </div>
        </div>

        
        <div class="detail-section">
            <h2 class="detail-section__title">Receiver Information</h2>
            <div class="detail-row">
                <span class="detail-row__label">Name</span>
                <span class="detail-row__value"><?php echo e($shipment->receiver_name); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Address</span>
                <span class="detail-row__value" style="white-space:pre-line"><?php echo e($shipment->receiver_address); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-row__label">Destination City</span>
                <span class="detail-row__value"><?php echo e($shipment->destination_city); ?></span>
            </div>
        </div>

    </div>

    
    <div class="card">
        <div style="padding:20px 28px 0; border-bottom:1px solid var(--line)">
            <h2 style="font-family:var(--font-mono); font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:16px">
                Status Timeline
            </h2>
        </div>

        <?php if($shipment->statusLogs->isEmpty()): ?>
            <div class="empty">
                <p class="empty__icon">🕓</p>
                <p class="empty__title">No status updates yet</p>
                <p class="empty__text">Status updates will appear here as the shipment progresses.</p>
            </div>
        <?php else: ?>
            <div class="timeline">
                <div class="timeline__track"></div>

                <?php $__currentLoopData = $shipment->statusLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $dotClass = match($log->status) {
                            'Delivered'  => 'timeline__dot--delivered',
                            'In Transit' => 'timeline__dot--transit',
                            default      => 'timeline__dot--pending',
                        };

                        $icon = match($log->status) {
                            'Delivered'  => '✓',
                            'In Transit' => '↻',
                            default      => '○',
                        };
                    ?>

                    <div class="timeline__item">
                        <div class="timeline__dot <?php echo e($dotClass); ?>"><?php echo e($icon); ?></div>
                        <div class="timeline__content">
                            <div class="timeline__header">
                                <span class="timeline__status"><?php echo e($log->status); ?></span>
                                <span class="badge badge--<?php echo e($log->status === 'In Transit' ? 'transit' : Str::slug($log->status)); ?>"
                                      style="font-size:.7rem; padding:2px 8px">
                                    <?php echo e($log->location); ?>

                                </span>
                            </div>
                            <?php if($log->note): ?>
                                <p class="timeline__note"><?php echo e($log->note); ?></p>
                            <?php endif; ?>
                            <p class="timeline__time">
                                <?php echo e($log->created_at->format('d M Y, g:i A')); ?>

                                &nbsp;·&nbsp;
                                <?php echo e($log->created_at->diffForHumans()); ?>

                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\shipment-tracker\resources\views/shipments/show.blade.php ENDPATH**/ ?>