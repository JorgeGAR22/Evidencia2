<?php $__env->startSection('title', 'Gestión de Órdenes'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Gestión de Órdenes</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Órdenes</h3>
            <div class="card-tools">
                <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Nueva Orden
                </a>
            </div>
        </div>
        <div class="card-body">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            
            <form action="<?php echo e(route('orders.index')); ?>" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="invoice_number">Buscar por # Factura:</label>
                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="<?php echo e(request('invoice_number')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer_name">Buscar por Nombre Cliente:</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo e(request('customer_name')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Estado:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Todos los Estados</option>
                                <option value="ordered" <?php echo e(request('status') == 'ordered' ? 'selected' : ''); ?>>Ordered</option>
                                <option value="in_process" <?php echo e(request('status') == 'in_process' ? 'selected' : ''); ?>>In process</option>
                                <option value="in_route" <?php echo e(request('status') == 'in_route' ? 'selected' : ''); ?>>In route</option>
                                <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-info mr-2"><i class="fas fa-search"></i> Buscar</button>
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Limpiar</a>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th># Factura</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Monto Total</th>
                        <th>Creada Por</th>
                        <th>Fecha de Orden</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($order->invoice_number); ?></td>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td>
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
                            </td>
                            <td>$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            
                            <td><?php echo e($order->creator ? $order->creator->name : 'N/A'); ?></td>
                            
                            <td><?php echo e($order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A'); ?></td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary btn-xs">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="<?php echo e(route('orders.edit', $order)); ?>" class="btn btn-info btn-xs">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                
                                <form action="<?php echo e(route('orders.destroy', $order)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('¿Estás seguro de archivar esta orden? No se eliminará permanentemente.')">
                                        <i class="fas fa-archive"></i> Archivar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay órdenes disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                <?php echo e($orders->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jorgearcibargon/activity-9/resources/views/orders/index.blade.php ENDPATH**/ ?>