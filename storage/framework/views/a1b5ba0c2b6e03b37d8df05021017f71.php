<?php $__env->startSection('title', 'Semua Pengeluaran'); ?>
<?php $__env->startSection('page-title', 'Semua Pengeluaran'); ?>
<?php $__env->startSection('page-subtitle', 'Monitor seluruh pengeluaran pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-filter me-2" style="color:#1565C0;"></i>Filter Pengeluaran</h6>
    </div>
    <div class="p-4">
        <form method="GET" action="<?php echo e(route('admin.expenses.index')); ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="user_id" class="form-select">
                        <option value="">Semua Pengguna</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($u->id); ?>" <?php echo e(request('user_id')==$u->id?'selected':''); ?>><?php echo e($u->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id')==$cat->id?'selected':''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>" placeholder="Dari tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>" placeholder="Sampai tanggal">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php if(request()->hasAny(['search','user_id','category_id','date_from','date_to'])): ?>
            <div class="mt-2">
                <a href="<?php echo e(route('admin.expenses.index')); ?>" class="btn btn-sm" style="color:#64748B;font-size:13px;"><i class="fas fa-times me-1"></i>Reset Filter</a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card-custom">
    <div class="card-header-custom">
        <h6><i class="fas fa-receipt me-2" style="color:#1565C0;"></i>Daftar Pengeluaran (<?php echo e($expenses->total()); ?> data)</h6>
        <div style="background:#EFF6FF;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:700;color:#1565C0;">
            Total: Rp <?php echo e(number_format($expenses->sum('amount'),0,',','.')); ?>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pengguna</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size:13px;color:#64748B;white-space:nowrap;"><?php echo e($exp->expense_date->format('d M Y')); ?></td>
                    <td>
                        <div style="font-size:13px;font-weight:600;color:#1E293B;"><?php echo e($exp->user->name); ?></div>
                        <div style="font-size:11px;color:#94A3B8;"><?php echo e($exp->user->business_name ?? '-'); ?></div>
                    </td>
                    <td style="font-weight:600;font-size:13px;"><?php echo e($exp->title); ?></td>
                    <td>
                        <span class="badge-cat" style="background:<?php echo e($exp->category->color); ?>20;color:<?php echo e($exp->category->color); ?>;">
                            <?php echo e($exp->category->name); ?>

                        </span>
                    </td>
                    <td style="font-weight:700;color:#1565C0;white-space:nowrap;">Rp <?php echo e(number_format($exp->amount,0,',','.')); ?></td>
                    <td style="font-size:12px;color:#64748B;"><?php echo e(Str::limit($exp->description??'-',30)); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.expenses.destroy', $exp)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-icon btn-red" title="Hapus"
                                onclick="return confirm('Hapus pengeluaran ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-receipt" style="font-size:48px;color:#CBD5E1;"></i>
                        <p class="mt-3" style="color:#94A3B8;">Tidak ada data pengeluaran.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($expenses->hasPages()): ?>
    <div class="p-4"><?php echo e($expenses->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/admin/expenses/index.blade.php ENDPATH**/ ?>