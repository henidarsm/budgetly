
<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .auth-wrapper {
        padding: 0 !important;
        min-height: 100vh !important;
        display: block !important;
        background: #ffffff !important;
    }

    .login-page {
        min-height: 100vh;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
    }

    .login-left {
        min-height: 100vh;
        background: linear-gradient(160deg, #0D47A1 0%, #1565C0 55%, #2196F3 100%);
        color: white;
        padding: 70px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: -90px;
        right: -90px;
        width: 260px;
        height: 260px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .login-left::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 230px;
        height: 230px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }

    .login-left-content {
        position: relative;
        z-index: 2;
        max-width: 440px;
        margin: 0 auto;
    }

    .login-left img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 18px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.18);
    }

    .login-left h3 {
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .login-left p {
        font-size: 15px;
        color: rgba(255,255,255,0.82);
        line-height: 1.7;
        margin-bottom: 28px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }

    .feature-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.18);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-text {
        font-size: 15px;
        color: rgba(255,255,255,0.94);
        font-weight: 500;
    }

    .login-right {
        min-height: 100vh;
        padding: 70px 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
    }

    .login-form-box {
        width: 100%;
        max-width: 520px;
    }

    .brand-logo {
        margin-bottom: 34px;
    }

    .login-form-box h4 {
        font-size: 30px;
        font-weight: 800;
        color: #1E293B;
        margin-bottom: 6px;
    }

    .login-subtitle {
        color: #64748B;
        font-size: 15px;
        margin-bottom: 34px;
    }

    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .input-group {
        border-radius: 14px;
    }

    .input-group-text {
        background: #F8FAFF;
        border: 2px solid #E5E7EB;
        border-right: none;
        border-radius: 14px 0 0 14px;
        padding-left: 18px;
        padding-right: 18px;
    }

    .input-group .form-control {
        border: 2px solid #E5E7EB;
        border-left: none;
        border-radius: 0 14px 14px 0;
        padding: 14px 16px;
        font-size: 15px;
    }

    .pass-toggle {
        cursor: pointer;
        background: #F8FAFF;
        border: 2px solid #E5E7EB;
        border-left: none;
        border-radius: 0 14px 14px 0;
    }

    .btn-primary-custom {
        padding: 15px 24px;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
    }

    .divider {
        margin: 26px 0;
    }

    @media (max-width: 992px) {
        .login-page {
            grid-template-columns: 1fr;
        }

        .login-left {
            display: none;
        }

        .login-right {
            padding: 40px 24px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-page">
    <div class="login-left">
        <div class="login-left-content">
            <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=700&h=420&fit=crop" alt="Budgetly Finance">

            <h3>Kelola Keuangan Usaha dengan Lebih Cerdas</h3>

            <p>
                Catat setiap pengeluaran, pantau kondisi keuangan, dan buat keputusan bisnis lebih tepat bersama Budgetly.
            </p>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-chart-pie" style="color:#64B5F6;"></i>
                </div>
                <div class="feature-text">Laporan visual berbasis kategori</div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-filter" style="color:#81C784;"></i>
                </div>
                <div class="feature-text">Filter & pencarian pengeluaran cepat</div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-file-pdf" style="color:#FF8A65;"></i>
                </div>
                <div class="feature-text">Ekspor laporan ke PDF & CSV</div>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="login-form-box">
            <div class="brand-logo">
                <div class="logo-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="logo-text">Budget<span>ly</span></div>
            </div>

            <h4>Selamat Datang Kembali!</h4>
            <p class="login-subtitle">Masuk ke akun Anda untuk melanjutkan.</p>

            <?php if($errors->any()): ?>
                <div class="alert" style="background:#FEF2F2;color:#991B1B;border-left:4px solid #EF4444;border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:20px;">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope" style="color:#1565C0;"></i>
                        </span>
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock" style="color:#1565C0;"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                        <button type="button" class="pass-toggle input-group-text" onclick="togglePassword('password','eyeIcon1')">
                            <i class="fas fa-eye" id="eyeIcon1" style="color:#94A3B8;font-size:15px;"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" style="border-radius:4px;border:2px solid #CBD5E1;">
                        <label class="form-check-label" for="remember" style="font-size:14px;color:#64748B;">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Sistem
                </button>
            </form>

            <div class="divider">
                <span>Belum punya akun?</span>
            </div>

            <div class="text-center mt-3">
                <a href="<?php echo e(route('register')); ?>" style="color:#1565C0;font-weight:600;text-decoration:none;font-size:15px;">
                    <i class="fas fa-user-plus me-1"></i> Daftar Sekarang — Gratis!
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\lonovo\budgetly\resources\views/auth/login.blade.php ENDPATH**/ ?>