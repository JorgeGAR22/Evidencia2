<?php $__env->startSection('title', 'Detalles de Orden'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Detalles de Orden: #<?php echo e($order->invoice_number); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Orden</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Número de Factura:</strong> <?php echo e($order->invoice_number); ?></p>
                    <p><strong>Cliente:</strong> <?php echo e($order->customer_name); ?></p>
                    <p><strong>Email Cliente:</strong> <?php echo e($order->customer_email ?? 'N/A'); ?></p>
                    <p><strong>Teléfono Cliente:</strong> <?php echo e($order->customer_phone ?? 'N/A'); ?></p>
                    <p><strong>Dirección de Entrega:</strong> <?php echo e($order->shipping_address); ?></p>
                    <p><strong>Monto Total:</strong> $<?php echo e(number_format($order->total_amount, 2)); ?></p>
                    <p><strong>Creada Por:</strong> <?php echo e($order->creator->name ?? 'N/A'); ?></p>
                    <p><strong>Fecha de Orden:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                    <p><strong>Última Actualización:</strong> <?php echo e($order->updated_at->format('d/m/Y H:i')); ?></p>
                    <p><strong>Estado:</strong>
                        <?php
                            $badgeClass = '';
                            switch ($order->status) {
                                case 'ordered': $badgeClass = 'badge-primary'; break;
                                case 'in_process': $badgeClass = 'badge-info'; break;
                                case 'in_route': $badgeClass = 'badge-warning'; break;
                                case 'delivered': $badgeClass = 'badge-success'; break;
                                case 'cancelled': $badgeClass = 'badge-danger'; break;
                                default: $badgeClass = 'badge-secondary'; break;
                            }
                        ?>
                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?></span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h4>Detalles del Proceso:</h4>
                    <p><strong>Nombre del Proceso:</strong> <?php echo e($order->process_name ?? 'N/A'); ?></p>
                    <p><strong>Fecha del Proceso:</strong> <?php echo e($order->process_date ? $order->process_date->format('d/m/Y H:i') : 'N/A'); ?></p>

                    <h4>Evidencias Fotográficas:</h4>
                    <?php if($order->in_route_photo_path): ?>
                        <p><strong>Foto en Ruta:</strong></p>
                        <img src="<?php echo e(Storage::url($order->in_route_photo_path)); ?>" alt="Foto en Ruta" class="img-fluid mb-2" style="max-width: 300px;">
                        <br><a href="<?php echo e(Storage::url($order->in_route_photo_path)); ?>" target="_blank">Ver en tamaño completo</a>
                    <?php else: ?>
                        <p>No hay foto en ruta.</p>
                    <?php endif; ?>

                    <?php if($order->delivered_photo_path): ?>
                        <p class="mt-3"><strong>Foto de Entrega:</strong></p>
                        <img src="<?php echo e(Storage::url($order->delivered_photo_path)); ?>" alt="Foto de Entrega" class="img-fluid mb-2" style="max-width: 300px;">
                        <br><a href="<?php echo e(Storage::url($order->delivered_photo_path)); ?>" target="_blank">Ver en tamaño completo</a>
                    <?php else: ?>
                        <p>No hay foto de entrega.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?php echo e(route('orders.edit', $order)); ?>" class="btn btn-info"><i class="fas fa-edit"></i> Editar Orden</a>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Listado</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jorgearcibargon/activity-9/resources/views/orders/show.blade.php ENDPATH**/ ?>