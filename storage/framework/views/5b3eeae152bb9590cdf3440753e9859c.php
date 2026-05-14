<?php $__env->startSection('title', 'Kelola Kategori'); ?>
<?php $__env->startSection('page-title', 'Kategori Pengeluaran'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola kategori untuk pengelompokan pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    
    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <h6><i class="fas fa-plus-circle me-2" style="color:#1565C0;"></i>Tambah Kategori Baru</h6>
            </div>
            <div class="p-4">
                <?php if($errors->any()): ?>
                    <div class="alert-custom alert-danger-custom mb-3 p-3 rounded-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><i class="fas fa-times me-1"></i><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('user.categories.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="cth: Bahan Baku, Transport..." value="<?php echo e(old('name')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna Kategori</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="color" class="form-control" value="<?php echo e(old('color', '#1565C0')); ?>" style="width:60px;height:42px;padding:4px;cursor:pointer;border-radius:10px;">
                            <div class="flex-grow-1">
                                <div style="font-size:12px;color:#64748B;">Pilih warna untuk label kategori</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Keterangan kategori..."><?php echo e(old('description')); ?></textarea>
                    </div>
                    <button type="submit" class="btn-primary-custom w-100">
                        <i class="fas fa-plus me-2"></i> Tambah Kategori
                    </button>
                </form>
            </div>
        </div>

        <div class="card-custom">
            <div class="p-0">
                <img src="https://images.unsplash.com/photo-1607863680198-23d4b2565df0?w=400&h=200&fit=crop" alt="categories" style="width:100%;height:160px;object-fit:cover;border-radius:16px 16px 0 0;">
                <div class="p-4">
                    <h6 style="font-weight:700;color:#1E293B;margin-bottom:8px;">Tentang Kategori</h6>
                    <p style="font-size:13px;color:#64748B;line-height:1.7;margin:0;">Kategori membantu Anda mengelompokkan pengeluaran agar lebih mudah dianalisis dalam laporan keuangan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <h6><i class="fas fa-user-tag me-2" style="color:#1565C0;"></i>Kategori Saya (<?php echo e($myCategories->count()); ?>)</h6>
            </div>
            <?php if($myCategories->isEmpty()): ?>
                <div class="p-5 text-center">
                    <i class="fas fa-tags" style="font-size:40px;color:#CBD5E1;"></i>
                    <p class="mt-3" style="color:#94A3B8;font-size:14px;">Belum ada kategori pribadi. Tambahkan di form sebelah!</p>
                </div>
            <?php else: ?>
            <div class="p-3">
                <div class="row g-3">
                    <?php $__currentLoopData = $myCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 d-flex align-items-center gap-3" style="background:#F8FAFF;border:1px solid #E8F0FE;">
                            <div style="width:42px;height:42px;background:<?php echo e($cat->color); ?>20;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid <?php echo e($cat->color); ?>40;">
                                <i class="fas fa-tag" style="color:<?php echo e($cat->color); ?>;font-size:16px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div style="font-weight:700;font-size:14px;color:#1E293B;"><?php echo e($cat->name); ?></div>
                                <div style="font-size:12px;color:#94A3B8;"><?php echo e($cat->expenses_count); ?> pengeluaran</div>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn-icon btn-blue" onclick="openEditModal(<?php echo e($cat->id); ?>, '<?php echo e($cat->name); ?>', '<?php echo e($cat->color); ?>', '<?php echo e($cat->description); ?>')" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if($cat->expenses_count == 0): ?>
                                <form method="POST" action="<?php echo e(route('user.categories.destroy', $cat)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-icon btn-red" title="Hapus" onclick="return confirm('Hapus kategori ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php else: ?>
                                <span class="btn-icon" title="Tidak bisa dihapus" style="background:#F1F5F9;color:#CBD5E1;cursor:not-allowed;">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="card-custom">
            <div class="card-header-custom">
                <h6><i class="fas fa-globe me-2" style="color:#7C3AED;"></i>Kategori Global (dari Admin) (<?php echo e($globalCategories->count()); ?>)</h6>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <?php $__currentLoopData = $globalCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 d-flex align-items-center gap-3" style="background:#FAFBFF;border:1px solid #E8F0FE;">
                            <div style="width:42px;height:42px;background:<?php echo e($cat->color); ?>20;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid <?php echo e($cat->color); ?>40;">
                                <i class="fas fa-tag" style="color:<?php echo e($cat->color); ?>;font-size:16px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div style="font-weight:700;font-size:14px;color:#1E293B;"><?php echo e($cat->name); ?></div>
                                <div style="font-size:12px;color:#94A3B8;"><?php echo e($cat->expenses_count); ?> pengeluaran &bull; Global</div>
                            </div>
                            <span style="background:#EDE9FE;color:#7C3AED;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                                <i class="fas fa-lock" style="font-size:9px;"></i> Global
                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
            <div class="modal-header" style="border-bottom:1px solid #F1F5F9;padding:20px 24px;">
                <h5 style="font-weight:700;color:#1E293B;margin:0;"><i class="fas fa-edit me-2" style="color:#1565C0;"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editForm">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <input type="color" name="color" id="editColor" class="form-control" style="width:80px;height:42px;padding:4px;border-radius:10px;cursor:pointer;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="editDesc" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #F1F5F9;padding:16px 24px;">
                    <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openEditModal(id, name, color, desc) {
    document.getElementById('editForm').action = '/user/categories/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editColor').value = color;
    document.getElementById('editDesc').value = desc || '';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/user/categories/index.blade.php ENDPATH**/ ?>