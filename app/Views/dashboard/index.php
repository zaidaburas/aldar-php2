<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?>
            <div class="flash flash-success"><?= e($message) ?></div>
        <?php endif; ?>

        <div class="hero-card" style="margin-bottom:20px">
            <span class="badge" style="background:rgba(255,255,255,.14); color:#fff">المرحلة الثالثة مكتملة</span>
            <h1>لوحة التحكم أصبحت شبه مكتملة للمطعم</h1>
            <p>تم استكمال إدارة السلايدر، معرض الصور، الإعدادات العامة، واختيار الوجبة المميزة من الأصناف الموجودة مسبقًا، بالإضافة إلى الحفاظ على فصل الكود ضمن معمارية MVC.</p>
        </div>

        <div class="grid stats">
            <div class="card stat"><strong><?= (int) $stats['categories'] ?></strong><span>إجمالي الأقسام</span></div>
            <div class="card stat"><strong><?= (int) $stats['items'] ?></strong><span>إجمالي الأصناف</span></div>
            <div class="card stat"><strong><?= (int) $stats['popular_items'] ?></strong><span>الأصناف الأكثر طلبًا</span></div>
            <div class="card stat"><strong><?= (int) $stats['active_items'] ?></strong><span>الأصناف النشطة</span></div>
            <div class="card stat"><strong><?= (int) $stats['slider_ads'] ?></strong><span>شرائح السلايدر النشطة</span></div>
            <div class="card stat"><strong><?= (int) $stats['gallery'] ?></strong><span>صور المعرض النشطة</span></div>
        </div>

        <div class="split" style="margin-top:20px">
            <div class="card panel">
                <div class="toolbar">
                    <div>
                        <h2 style="margin:0 0 8px">الوحدات الجاهزة الآن</h2>
                        <p class="muted" style="margin:0">يمكنك الآن إدارة غالبية محتوى الموقع من لوحة التحكم بدون تعديل يدوي للملفات.</p>
                    </div>
                    <div class="actions">
                        <a class="btn btn-secondary" href="<?= e(url('/slider')) ?>">إدارة السلايدر</a>
                        <a class="btn btn-secondary" href="<?= e(url('/gallery')) ?>">إدارة المعرض</a>
                        <a class="btn btn-primary" href="<?= e(url('/settings')) ?>">الإعدادات العامة</a>
                    </div>
                </div>
                <table class="table" style="min-width:unset">
                    <thead>
                        <tr><th>الوحدة</th><th>الوصف</th><th>الحالة</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>الأقسام</td><td>إضافة وتعديل وحذف وترتيب وتفعيل الأقسام</td><td><span class="status active">جاهز</span></td></tr>
                        <tr><td>الأصناف</td><td>إدارة كاملة مع الصور والوصف والسعر والأكثر طلبًا</td><td><span class="status active">جاهز</span></td></tr>
                        <tr><td>السلايدر</td><td>إضافة الشرائح، الصور، الروابط، النصوص، والتحكم بالتفعيل</td><td><span class="status active">جاهز</span></td></tr>
                        <tr><td>المعرض</td><td>إضافة وتعديل وحذف صور المعرض مع ترتيب العرض</td><td><span class="status active">جاهز</span></td></tr>
                        <tr><td>الإعدادات العامة</td><td>روابط الطلب والواتساب واتصل بنا ومن نحن والوجبة المميزة</td><td><span class="status active">جاهز</span></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card panel">
                <h3 style="margin-top:0">ماذا بقي بعد هذه المرحلة</h3>
                <div class="meta-list">
                    <div class="meta-item">ربط الواجهة الأمامية الحالية بقاعدة البيانات بدل البيانات الثابتة.</div>
                    <div class="meta-item">اختياري: بناء API داخلي لقراءة البيانات ديناميكيًا.</div>
                    <div class="meta-item">اختياري: تحسين الصلاحيات وتعدد المستخدمين للمشرفين.</div>
                    <div class="meta-item">اختياري: استيراد المنيو الحالي إلى قاعدة البيانات دفعة واحدة.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
