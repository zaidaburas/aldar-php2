<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?><div class="flash flash-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>

        <div class="card panel">
            <div class="toolbar">
                <div>
                    <span class="badge">السلايدر العلوي</span>
                    <h1 style="margin:10px 0 6px">إدارة الإعلانات والشرائح</h1>
                    <p class="muted" style="margin:0">تحكم بصور السلايدر والعناوين والروابط مع إمكانية إخفاء أي شريحة وقت الحاجة.</p>
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= e(url('/slider/create')) ?>">+ إضافة شريحة</a>
                </div>
            </div>

            <?php if (!$slides): ?>
                <div class="empty-state">
                    <h3>لا توجد شرائح بعد</h3>
                    <p>ابدأ بإضافة أول شريحة لتظهر في أعلى الموقع.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المعاينة</th>
                                <th>العنوان</th>
                                <th>الوصف</th>
                                <th>الرابط</th>
                                <th>الزر</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($slides as $slide): ?>
                                <tr>
                                    <td><?= (int) $slide['id'] ?></td>
                                    <td><div class="thumb"><img src="<?= e(upload_url($slide['image_path'])) ?>" alt="<?= e($slide['title']) ?>"></div></td>
                                    <td><div style="font-weight:800"><?= e($slide['title']) ?></div></td>
                                    <td class="mini"><?= e($slide['subtitle'] ?: '—') ?></td>
                                    <td class="mini"><?= e($slide['link_url'] ?: '—') ?></td>
                                    <td><?= e($slide['button_text'] ?: '—') ?></td>
                                    <td><?= (int) $slide['sort_order'] ?></td>
                                    <td><span class="status <?= (int) $slide['is_active'] === 1 ? 'active' : 'inactive' ?>"><?= (int) $slide['is_active'] === 1 ? 'نشط' : 'مخفي' ?></span></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= e(url('/slider/edit?id=' . (int) $slide['id'])) ?>">تعديل</a>
                                            <form method="POST" action="<?= e(url('/slider/delete')) ?>" onsubmit="return confirm('هل أنت متأكد من حذف هذه الشريحة؟');">
                                                <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $slide['id'] ?>">
                                                <button class="btn btn-danger" type="submit">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
