<?php $__env->startSection('title', 'Laporan Pengeluaran'); ?>
<?php $__env->startSection('page-title', 'Laporan Pengeluaran'); ?>
<?php $__env->startSection('page-subtitle', 'Analisis pengeluaran berdasarkan kategori dan periode'); ?>

<?php $__env->startSection('content'); ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-sliders-h me-2" style="color:#1565C0;"></i>Filter Laporan</h6>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('user.reports.pdf', request()->query())); ?>" class="btn btn-sm" style="background:#FEF2F2;color:#DC2626;border-radius:8px;padding:7px 14px;font-weight:600;font-size:12px;border:none;">
                <i class="fas fa-file-pdf me-1"></i> Export PDF
            </a>
            <a href="<?php echo e(route('user.reports.csv', request()->query())); ?>" class="btn btn-sm" style="background:#F0FDF4;color:#16A34A;border-radius:8px;padding:7px 14px;font-weight:600;font-size:12px;border:none;">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
    </div>
    <div class="p-4">
        <form method="GET" action="<?php echo e(route('user.reports.index')); ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" style="font-size:13px;">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo e($dateFrom); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:13px;">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo e($dateTo); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:13px;">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e($categoryId==$cat->id?'selected':''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-primary-custom flex-grow-1"><i class="fas fa-chart-bar me-1"></i>Tampilkan</button>
                    <a href="<?php echo e(route('user.reports.index')); ?>" class="btn-outline-custom" style="padding:10px 14px;"><i class="fas fa-redo"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="stat-icon mx-auto mb-3" style="background:#EFF6FF;width:56px;height:56px;"><i class="fas fa-coins" style="color:#1565C0;font-size:22px;"></i></div>
            <div style="font-size:12px;color:#64748B;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Total Pengeluaran</div>
            <div style="font-size:24px;font-weight:800;color:#1565C0;margin:6px 0;">Rp <?php echo e(number_format($totalAmount,0,',','.')); ?></div>
            <div style="font-size:12px;color:#94A3B8;"><?php echo e(\Carbon\Carbon::parse($dateFrom)->format('d M Y')); ?> – <?php echo e(\Carbon\Carbon::parse($dateTo)->format('d M Y')); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="stat-icon mx-auto mb-3" style="background:#F0FDF4;width:56px;height:56px;"><i class="fas fa-receipt" style="color:#16A34A;font-size:22px;"></i></div>
            <div style="font-size:12px;color:#64748B;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Jumlah Transaksi</div>
            <div style="font-size:24px;font-weight:800;color:#16A34A;margin:6px 0;"><?php echo e($expenses->count()); ?></div>
            <div style="font-size:12px;color:#94A3B8;">transaksi tercatat</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="stat-icon mx-auto mb-3" style="background:#FFF7ED;width:56px;height:56px;"><i class="fas fa-calculator" style="color:#EA580C;font-size:22px;"></i></div>
            <div style="font-size:12px;color:#64748B;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Rata-rata per Transaksi</div>
            <div style="font-size:24px;font-weight:800;color:#EA580C;margin:6px 0;">
                Rp <?php echo e($expenses->count() > 0 ? number_format($totalAmount/$expenses->count(),0,',','.') : 0); ?>

            </div>
            <div style="font-size:12px;color:#94A3B8;">per pengeluaran</div>
        </div>
    </div>
</div>


<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-pie me-2" style="color:#7C3AED;"></i>Distribusi per Kategori</h6>
            </div>
            <div class="p-3 d-flex justify-content-center align-items-center" style="height:300px;">
                <?php if($categoryBreakdown->isNotEmpty()): ?>
                    <canvas id="pieChart" style="max-height:240px;max-width:240px;"></canvas>
                <?php else: ?>
                    <div class="text-center py-4" style="color:#94A3B8;">Tidak ada data untuk ditampilkan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-line me-2" style="color:#1565C0;"></i>Tren Harian</h6>
            </div>
            <div class="p-3" style="height:300px;">
                <?php if($dailyBreakdown->isNotEmpty()): ?>
                    <canvas id="lineChart" style="max-height:240px;"></canvas>
                <?php else: ?>
                    <div class="text-center py-4" style="color:#94A3B8;">Tidak ada data untuk ditampilkan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php if($categoryBreakdown->isNotEmpty()): ?>
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <h6><i class="fas fa-list-alt me-2" style="color:#1565C0;"></i>Rincian per Kategori</h6>
    </div>
    <div class="p-4">
        <div class="row g-3">
            <?php $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $pct = $totalAmount > 0 ? ($cat['total']/$totalAmount)*100 : 0; ?>
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:#F8FAFF;border:1px solid #E8F0FE;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:12px;height:12px;background:<?php echo e($cat['color']); ?>;border-radius:50%;"></div>
                            <span style="font-weight:700;font-size:14px;color:#1E293B;"><?php echo e($cat['name']); ?></span>
                        </div>
                        <div class="text-end">
                            <div style="font-weight:800;font-size:14px;color:#1565C0;">Rp <?php echo e(number_format($cat['total'],0,',','.')); ?></div>
                            <div style="font-size:11px;color:#94A3B8;"><?php echo e($cat['count']); ?> transaksi</div>
                        </div>
                    </div>
                    <div style="height:8px;background:#E8F0FE;border-radius:10px;">
                        <div style="height:8px;background:<?php echo e($cat['color']); ?>;border-radius:10px;width:<?php echo e($pct); ?>%;"></div>
                    </div>
                    <div style="font-size:12px;color:#64748B;margin-top:4px;font-weight:600;"><?php echo e(number_format($pct,1)); ?>% dari total</div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="card-custom">
    <div class="card-header-custom">
        <h6><i class="fas fa-table me-2" style="color:#1565C0;"></i>Detail Transaksi</h6>
        <div style="background:#EFF6FF;padding:6px 14px;border-radius:8px;font-size:13px;font-weight:700;color:#1565C0;">
            <?php echo e($expenses->count()); ?> data
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:#94A3B8;font-size:13px;"><?php echo e($i+1); ?></td>
                    <td style="font-size:13px;color:#64748B;white-space:nowrap;"><?php echo e($exp->expense_date->format('d M Y')); ?></td>
                    <td style="font-weight:600;font-size:13px;"><?php echo e($exp->title); ?></td>
                    <td>
                        <span class="badge-cat" style="background:<?php echo e($exp->category->color); ?>20;color:<?php echo e($exp->category->color); ?>;">
                            <?php echo e($exp->category->name); ?>

                        </span>
                    </td>
                    <td style="font-weight:700;color:#1565C0;white-space:nowrap;">Rp <?php echo e(number_format($exp->amount,0,',','.')); ?></td>
                    <td style="font-size:12px;color:#64748B;"><?php echo e(Str::limit($exp->description??'-',30)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-chart-bar" style="font-size:40px;color:#CBD5E1;"></i>
                        <p class="mt-3" style="color:#94A3B8;">Tidak ada data untuk periode ini.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
            <?php if($expenses->count() > 0): ?>
            <tfoot>
                <tr style="background:#EFF6FF;">
                    <td colspan="4" style="font-weight:800;color:#1565C0;font-size:14px;padding:14px 16px;">TOTAL</td>
                    <td style="font-weight:800;color:#1565C0;font-size:14px;padding:14px 16px;">Rp <?php echo e(number_format($totalAmount,0,',','.')); ?></td>
                    <td></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
<?php if($categoryBreakdown->isNotEmpty()): ?>
const pieLabels = <?php echo json_encode($categoryBreakdown->pluck('name')->toArray()); ?>;
const pieValues = <?php echo json_encode($categoryBreakdown->pluck('total')->toArray()); ?>;
const pieColors = <?php echo json_encode($categoryBreakdown->pluck('color')->toArray()); ?>;
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: { labels: pieLabels, datasets: [{ data: pieValues, backgroundColor: pieColors, borderWidth: 3, borderColor: '#fff' }] },
    options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } } } }
});
<?php endif; ?>

<?php if($dailyBreakdown->isNotEmpty()): ?>
const dailyLabels = <?php echo json_encode($dailyBreakdown->keys()->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray()); ?>;
const dailyValues = <?php echo json_encode($dailyBreakdown->values()->toArray()); ?>;
new Chart(document.getElementById('lineChart'), {
    type: 'bar',
    data: {
        labels: dailyLabels,
        datasets: [{ label: 'Pengeluaran', data: dailyValues, backgroundColor: 'rgba(21,101,192,0.15)', borderColor: '#1565C0', borderWidth: 2, borderRadius: 6 }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => 'Rp' + (v/1000) + 'Rb' }, grid: { color: '#F1F5F9' } },
            x: { grid: { display: false } }
        }
    }
});
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/user/reports/index.blade.php ENDPATH**/ ?>