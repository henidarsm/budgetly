<?php $__env->startSection('title', 'Daftar Akun'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .auth-wrapper {
        padding: 0 !important;
        min-height: 100vh !important;
        display: block !important;
        background: #ffffff !important;
    }

    .register-page {
        min-height: 100vh;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #ffffff;
    }

    .register-left {
        min-height: 100vh;
        background: linear-gradient(160deg, #0D47A1 0%, #1565C0 55%, #2196F3 100%);
        color: white;
        padding: 60px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .register-left::before {
        content: '';
        position: absolute;
        top: -90px;
        right: -90px;
        width: 260px;
        height: 260px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .register-left::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 230px;
        height: 230px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }

    .register-left-content {
        position: relative;
        z-index: 2;
        max-width: 440px;
        margin: 0 auto;
    }

    .register-left img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 18px;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.18);
    }

    .register-left h3 {
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .register-left p {
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

    .register-right {
        min-height: 100vh;
        padding: 40px 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
    }

    .register-form-box {
        width: 100%;
        max-width: 520px;
    }

    .brand-logo {
        margin-bottom: 22px;
    }

    .register-form-box h4 {
        font-size: 30px;
        font-weight: 800;
        color: #1E293B;
        margin-bottom: 6px;
    }

    .register-subtitle {
        color: #64748B;
        font-size: 15px;
        margin-bottom: 22px;
    }

    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 14px;
        margin-bottom: 8px;
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
        padding: 13px 16px;
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
        margin: 20px 0;
    }

    @media (max-width: 992px) {
        .register-page {
            grid-template-columns: 1fr;
        }

        .register-left {
            display: none;
        }

        .register-right {
            padding: 40px 24px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="register-page">
    <div class="register-left">
        <div class="register-left-content">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=700&h=420&fit=crop" alt="Register">

            <h3>Mulai Perjalanan Keuangan Anda!</h3>

            <p>
                Bergabung dan mulai catat pengeluaran usaha dengan lebih rapi, mudah, dan terkontrol bersama Budgetly.
            </p>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shield-halved" style="color:#64B5F6;"></i>
                </div>
                <div class="feature-text">Data aman & terenkripsi</div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-bolt" style="color:#FFD54F;"></i>
                </div>
                <div class="feature-text">Akses langsung tanpa biaya</div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-mobile-screen" style="color:#A5D6A7;"></i>
                </div>
                <div class="feature-text">Responsif di semua perangkat</div>
            </div>
        </div>
    </div>

    <div class="register-right">
        <div class="register-form-box">
            <div class="brand-logo">
                <div class="logo-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="logo-text">Budget<span>ly</span></div>
            </div>

            <h4>Buat Akun Baru</h4>
            <p class="register-subtitle">Isi data di bawah untuk mendaftar.</p>

            <?php if($errors->any()): ?>
                <div class="alert" style="background:#FEF2F2;color:#991B1B;border-left:4px solid #EF4444;border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:20px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($e); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register.post')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span style="color:#EF4444;">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user" style="color:#1565C0;"></i>
                        </span>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap Anda" value="<?php echo e(old('name')); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Email <span style="color:#EF4444;">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope" style="color:#1565C0;"></i>
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Usaha</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-store" style="color:#1565C0;"></i>
                        </span>
                        <input type="text" name="business_name" class="form-control" placeholder="Nama usaha Anda (opsional)" value="<?php echo e(old('business_name')); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone" style="color:#1565C0;"></i>
                        </span>
                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx (opsional)" value="<?php echo e(old('phone')); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kata Sandi <span style="color:#EF4444;">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock" style="color:#1565C0;"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="pass-toggle input-group-text" onclick="togglePassword('password','eye1')">
                            <i class="fas fa-eye" id="eye1" style="color:#94A3B8;font-size:15px;"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Kata Sandi <span style="color:#EF4444;">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock" style="color:#1565C0;"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password2" class="form-control" placeholder="Ulangi kata sandi" required>
                        <button type="button" class="pass-toggle input-group-text" onclick="togglePassword('password2','eye2')">
                            <i class="fas fa-eye" id="eye2" style="color:#94A3B8;font-size:15px;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom mb-3">
                    <i class="fas fa-user-plus me-2"></i> Buat Akun Sekarang
                </button>
            </form>

            <div class="divider">
                <span>Sudah punya akun?</span>
            </div>

            <div class="text-center mt-3">
                <a href="<?php echo e(route('login')); ?>" style="color:#1565C0;font-weight:600;text-decoration:none;font-size:15px;">
                    <i class="fas fa-sign-in-alt me-1"></i> Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\budgetly bismillah ga error\resources\views/auth/register.blade.php ENDPATH**/ ?>