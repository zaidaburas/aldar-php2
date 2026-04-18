<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?><div class="flash flash-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>

        <div class="card panel">
            <div class="toolbar">
                <div>
                    <span class="badge">معرض الصور</span>
                    <h1 style="margin:10px 0 6px">إدارة صور المطعم</h1>
                    <p class="muted" style="margin:0">أضف صور الأطباق أو الأجواء أو الواجهة الرئيسية، وتحكم بترتيبها وظهورها.</p>
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= e(url('/gallery/create')) ?>">+ إضافة صورة</a>
                </div>
            </div>

            <?php if (!$images): ?>
                <div class="empty-state">
                    <h3>لا توجد صور في المعرض بعد</h3>
                    <p>أضف أول صورة ليصبح المعرض جاهزًا للعرض في الموقع.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المعاينة</th>
                                <th>العنوان</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($images as $image): ?>
                                <tr>
                                    <td><?= (int) $image['id'] ?></td>
                                    <td><div class="thumb"><img src="<?= e(upload_url($image['image_path'])) ?>" alt="<?= e($image['title']) ?>"></div></td>
                                    <td>
                                        <div style="font-weight:800"><?= e($image['title']) ?></div>
                                        <div class="mini"><?= e($image['image_path']) ?></div>
                                    </td>
                                    <td><?= (int) $image['sort_order'] ?></td>
                                    <td><span class="status <?= (int) $image['is_active'] === 1 ? 'active' : 'inactive' ?>"><?= (int) $image['is_active'] === 1 ? 'نشط' : 'مخفي' ?></span></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= e(url('/gallery/edit?id=' . (int) $image['id'])) ?>">تعديل</a>
                                            <form method="POST" action="<?= e(url('/gallery/delete')) ?>" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟');">
                                                <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $image['id'] ?>">
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
