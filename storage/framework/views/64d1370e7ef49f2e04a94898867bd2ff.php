<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Budgetly'); ?> - Sistem Pencatatan Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #ffffff;  min-height: 100vh; }
        .auth-wrapper { min-height: 100vh; display: flex; align-items: stretch; justify-content: center; padding: 0; }
        .auth-card { background: #fff; border-radius: 0; overflow: hidden; box-shadow: none; max-width: 100%; width: 100%;  min-height: 100vh; }
        .auth-left { background: linear-gradient(160deg, #0D47A1 0%, #1565C0 55%, #1976D2 100%); padding: 70px 80px; color: white; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;  min-height: 100vh}
        .auth-left::before { content: ''; position: absolute; top: -80px; right: -80px; width: 250px; height: 250px; background: rgba(255,255,255,0.08); border-radius: 50%; }
        .auth-left::after { content: ''; position: absolute; bottom: -60px; left: -60px; width: 200px; height: 200px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .auth-left img { width: 100%; height: 220px; object-fit: cover; border-radius: 16px; margin-bottom: 24px; }
        .auth-right { padding: 70px 90px; display: flex; flex-direction: column; justify-content: center;  min-height: 100vh}
        .brand-logo { display: flex; align-items: center; gap: 12px; margin-bottom: 30px; }
        .brand-logo .logo-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #1565C0, #42A5F5); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .brand-logo .logo-icon i { color: white; font-size: 22px; }
        .brand-logo .logo-text { font-size: 24px; font-weight: 800; color: #0D47A1; }
        .brand-logo .logo-text span { color: #42A5F5; }
        .form-label { font-weight: 600; color: #374151; font-size: 14px; }
        .form-control { border: 2px solid #E5E7EB; border-radius: 12px; padding: 12px 16px; font-size: 15px; transition: all .3s; }
        .form-control:focus { border-color: #1565C0; box-shadow: 0 0 0 4px rgba(21,101,192,0.12); }
        .btn-primary-custom { background: linear-gradient(135deg, #1565C0, #1976D2); border: none; border-radius: 12px; padding: 14px 24px; font-size: 16px; font-weight: 600; color: white; width: 100%; transition: all .3s; letter-spacing: .3px; }
        .btn-primary-custom:hover { background: linear-gradient(135deg, #0D47A1, #1565C0); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(21,101,192,0.4); color: white; }
        .input-group-text { background: #F8FAFF; border: 2px solid #E5E7EB; border-right: none; border-radius: 12px 0 0 12px; }
        .input-group .form-control { border-left: none; border-radius: 0 12px 12px 0; }
        .input-group .form-control:focus { border-color: #1565C0; }
        .input-group:focus-within .input-group-text { border-color: #1565C0; }
        .divider { position: relative; text-align: center; margin: 20px 0; }
        .divider::before { content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 1px; background: #E5E7EB; }
        .divider span { background: white; padding: 0 16px; color: #9CA3AF; font-size: 14px; position: relative; }
        .feature-item { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .feature-icon { width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-text { font-size: 14px; color: rgba(255,255,255,0.9); }
        .pass-toggle { cursor: pointer; background: #F8FAFF; border: 2px solid #E5E7EB; border-left: none; border-radius: 0 12px 12px 0; }
        .pass-toggle:hover { background: #EFF6FF; }
        @media (max-width: 768px) { .auth-left { display: none; } .auth-right { padding: 40px 24px; } }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<div class="auth-wrapper">
    <?php echo $__env->yieldContent('content'); ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\lonovo\budgetly\resources\views/layouts/app.blade.php ENDPATH**/ ?>