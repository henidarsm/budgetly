<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran - <?php echo e($user->name); ?></title>
    <style>
        * { font-family: 'DejaVu Sans', Arial, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: white; color: #1E293B; font-size: 12px; }
        .header { background: linear-gradient(135deg, #0D47A1, #1565C0); color: white; padding: 24px 30px; border-radius: 0; }
        .header h1 { font-size: 22px; font-weight: bold; margin-bottom: 4px; }
        .header p { font-size: 12px; color: rgba(255,255,255,0.8); }
        .meta { padding: 16px 30px; background: #F8FAFF; border-bottom: 2px solid #DBEAFE; display: flex; justify-content: space-between; }
        .meta-item { }
        .meta-label { font-size: 10px; color: #64748B; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px; }
        .meta-value { font-size: 13px; font-weight: bold; color: #1E293B; margin-top: 2px; }
        .content { padding: 20px 30px; }
        .summary-grid { display: table; width: 100%; margin-bottom: 20px; }
        .summary-item { display: table-cell; background: #EFF6FF; border: 1px solid #BFDBFE; padding: 12px 16px; text-align: center; border-radius: 8px; }
        .summary-label { font-size: 10px; color: #64748B; text-transform: uppercase; font-weight: bold; }
        .summary-value { font-size: 16px; font-weight: bold; color: #1565C0; margin-top: 4px; }
        .section-title { font-size: 13px; font-weight: bold; color: #1565C0; margin: 16px 0 10px; padding-bottom: 6px; border-bottom: 2px solid #DBEAFE; }
        .cat-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .cat-table th { background: #1565C0; color: white; padding: 8px 10px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        .cat-table td { padding: 8px 10px; border-bottom: 1px solid #F1F5F9; font-size: 11px; }
        .cat-table tr:nth-child(even) td { background: #F8FAFF; }
        .main-table { width: 100%; border-collapse: collapse; }
        .main-table th { background: #1565C0; color: white; padding: 8px 10px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
        .main-table td { padding: 8px 10px; border-bottom: 1px solid #F1F5F9; font-size: 11px; }
        .main-table tr:nth-child(even) td { background: #F8FAFF; }
        .total-row td { background: #EFF6FF !important; font-weight: bold; color: #1565C0; font-size: 12px; }
        .footer { margin-top: 20px; padding: 12px 30px; background: #F8FAFF; text-align: center; font-size: 10px; color: #94A3B8; border-top: 1px solid #E5E7EB; }
        .amount { text-align: right; font-weight: bold; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
<div class="header">
    <h1>BUDGETLY — Laporan Pengeluaran</h1>
    <p>Sistem Pencatatan Pengeluaran Usaha</p>
</div>

<div style="padding: 12px 30px; background: #DBEAFE; display: table; width: 100%;">
    <div style="display: table-cell; width: 50%;">
        <div style="font-size: 10px; color: #1E40AF; text-transform: uppercase; font-weight: bold;">Nama</div>
        <div style="font-size: 13px; font-weight: bold; color: #1E293B;"><?php echo e($user->name); ?></div>
    </div>
    <div style="display: table-cell; width: 50%;">
        <div style="font-size: 10px; color: #1E40AF; text-transform: uppercase; font-weight: bold;">Nama Usaha</div>
        <div style="font-size: 13px; font-weight: bold; color: #1E293B;"><?php echo e($user->business_name ?? '-'); ?></div>
    </div>
</div>
<div style="padding: 10px 30px; background: #EFF6FF; display: table; width: 100%;">
    <div style="display: table-cell; width: 33%;">
        <div style="font-size: 10px; color: #64748B;">Periode Dari</div>
        <div style="font-weight: bold;"><?php echo e(\Carbon\Carbon::parse($dateFrom)->format('d F Y')); ?></div>
    </div>
    <div style="display: table-cell; width: 33%;">
        <div style="font-size: 10px; color: #64748B;">Periode Sampai</div>
        <div style="font-weight: bold;"><?php echo e(\Carbon\Carbon::parse($dateTo)->format('d F Y')); ?></div>
    </div>
    <div style="display: table-cell; width: 33%;">
        <div style="font-size: 10px; color: #64748B;">Dicetak Pada</div>
        <div style="font-weight: bold;"><?php echo e(now()->format('d F Y, H:i')); ?></div>
    </div>
</div>

<div class="content">
    <div style="background: #1565C0; color: white; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; display: table; width: 100%;">
        <div style="display: table-cell; width: 60%;">
            <div style="font-size: 10px; color: rgba(255,255,255,0.7); text-transform: uppercase;">Total Pengeluaran Periode</div>
            <div style="font-size: 20px; font-weight: bold; margin-top: 4px;">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></div>
        </div>
        <div style="display: table-cell; width: 40%; text-align: right;">
            <div style="font-size: 10px; color: rgba(255,255,255,0.7); text-transform: uppercase;">Jumlah Transaksi</div>
            <div style="font-size: 20px; font-weight: bold; margin-top: 4px;"><?php echo e($expenses->count()); ?></div>
        </div>
    </div>

    <div class="section-title">RINGKASAN PER KATEGORI</div>
    <table class="cat-table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="amount">Total Pengeluaran</th>
                <th class="amount">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cat['name']); ?></td>
                <td class="amount">Rp <?php echo e(number_format($cat['total'], 0, ',', '.')); ?></td>
                <td class="amount"><?php echo e($totalAmount > 0 ? number_format(($cat['total']/$totalAmount)*100, 1) : 0); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="amount">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></td>
                <td class="amount">100%</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">DETAIL TRANSAKSI</div>
    <table class="main-table">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:15%">Tanggal</th>
                <th style="width:28%">Judul Pengeluaran</th>
                <th style="width:18%">Kategori</th>
                <th class="amount" style="width:20%">Jumlah</th>
                <th style="width:14%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($i + 1); ?></td>
                <td><?php echo e($exp->expense_date->format('d/m/Y')); ?></td>
                <td><?php echo e($exp->title); ?></td>
                <td><?php echo e($exp->category->name); ?></td>
                <td class="amount">Rp <?php echo e(number_format($exp->amount, 0, ',', '.')); ?></td>
                <td><?php echo e(Str::limit($exp->description ?? '-', 20)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr class="total-row">
                <td colspan="4">TOTAL KESELURUHAN</td>
                <td class="amount">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="footer">
    Laporan ini dibuat secara otomatis oleh sistem Budgetly &bull; <?php echo e(now()->format('d F Y H:i:s')); ?> &bull; Budgetly &copy; <?php echo e(date('Y')); ?>

</div>
</body>
</html>
<?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/user/reports/pdf.blade.php ENDPATH**/ ?>