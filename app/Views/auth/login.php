<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<div class="login-shell">
    <div class="card login-card">
        <div style="margin-bottom:22px">
            <span class="badge">المرحلة الأولى</span>
            <h1 style="margin:12px 0 8px">تسجيل دخول المشرف</h1>
            <p class="muted">تم تجهيز نواة المشروع بمعمارية MVC مع نظام دخول آمن باستخدام PDO و CSRF.</p>
        </div>

        <?php if ($message = flash('error')): ?>
            <div class="flash flash-error"><?= e($message) ?></div>
        <?php endif; ?>

        <?php if ($message = flash('success')): ?>
            <div class="flash flash-success"><?= e($message) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= e(url('/login')) ?>">
            <input type="hidden" name="_token" value="<?= e($csrf) ?>">

            <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input class="input" id="username" name="username" value="<?= e(old('username')) ?>" placeholder="admin">
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input class="input" id="password" type="password" name="password" placeholder="••••••••">
            </div>

            <button class="btn btn-primary" type="submit" style="width:100%">دخول لوحة التحكم</button>
        </form>

        <div class="footer-note">بيانات الدخول الافتراضية بعد استيراد قاعدة البيانات: <strong>admin</strong> / <strong>admin123</strong></div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
