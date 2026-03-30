<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation">
        <div class="pagination__links">

            
            <?php if($paginator->onFirstPage()): ?>
                <span aria-disabled="true" class="disabled">
                    <span>&lsaquo;</span>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="Previous">&lsaquo;</a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span aria-disabled="true"><span><?php echo e($element); ?></span></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span aria-current="page"><span><?php echo e($page); ?></span></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="Next">&rsaquo;</a>
            <?php else: ?>
                <span aria-disabled="true" class="disabled">
                    <span>&rsaquo;</span>
                </span>
            <?php endif; ?>

        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\shipment-tracker\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>