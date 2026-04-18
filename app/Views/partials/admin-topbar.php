<div class="topbar">
    <div class="container topbar-row">
        <div class="brand">
            <strong>مطاعم الدار - لوحة التحكم</strong>
            <span><?= e($pageSubtitle ?? 'لوحة الإدارة وربط المحتوى الديناميكي') ?></span>
        </div>
        <div class="nav-links">
            <a class="<?= is_active_path('/dashboard') ? 'active' : '' ?>" href="<?= e(url('/dashboard')) ?>">الرئيسية</a>
            <a class="<?= is_active_path('/categories') ? 'active' : '' ?>" href="<?= e(url('/categories')) ?>">الأقسام</a>
            <a class="<?= is_active_path('/items') ? 'active' : '' ?>" href="<?= e(url('/items')) ?>">الأصناف</a>
            <a class="<?= is_active_path('/slider') ? 'active' : '' ?>" href="<?= e(url('/slider')) ?>">السلايدر</a>
            <a class="<?= is_active_path('/gallery') ? 'active' : '' ?>" href="<?= e(url('/gallery')) ?>">المعرض</a>
            <a class="<?= is_active_path('/settings') ? 'active' : '' ?>" href="<?= e(url('/settings')) ?>">الإعدادات</a>
            <form method="POST" action="<?= e(url('/logout')) ?>" style="margin:0">
                <input type="hidden" name="_token" value="<?= e($csrf ?? '') ?>">
                <button class="btn btn-light" type="submit">تسجيل خروج</button>
            </form>
        </div>
    </div>
</div>
