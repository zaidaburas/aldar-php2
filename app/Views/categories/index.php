<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?><div class="flash flash-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>

        <div class="card panel">
            <div class="toolbar">
                <div>
                    <span class="badge">إدارة الأقسام</span>
                    <h1 style="margin:10px 0 6px">الأقسام الرئيسية للمنيو</h1>
                    <p class="muted" style="margin:0">يمكنك من هنا ترتيب الأقسام وتفعيلها واختيار الأيقونة المناسبة لكل قسم.</p>
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= e(url('/categories/create')) ?>">+ إضافة قسم جديد</a>
                </div>
            </div>

            <?php if (!$categories): ?>
                <div class="empty-state">
                    <h3>لا توجد أقسام بعد</h3>
                    <p>ابدأ بإضافة أول قسم ليظهر لاحقًا داخل الموقع والواجهة الأمامية.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>القسم</th>
                                <th>Slug</th>
                                <th>الوصف</th>
                                <th>الترتيب</th>
                                <th>الأصناف</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= (int) $category['id'] ?></td>
                                    <td>
                                        <div style="font-weight:800"><?= e($category['icon']) ?> <?= e($category['name']) ?></div>
                                    </td>
                                    <td><span class="chip"><?= e($category['slug']) ?></span></td>
                                    <td class="mini"><?= e($category['description'] ?: '—') ?></td>
                                    <td><?= (int) $category['sort_order'] ?></td>
                                    <td><?= (int) $category['items_count'] ?></td>
                                    <td>
                                        <span class="status <?= (int) $category['is_active'] === 1 ? 'active' : 'inactive' ?>">
                                            <?= (int) $category['is_active'] === 1 ? 'نشط' : 'مخفي' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= e(url('/categories/edit?id=' . (int) $category['id'])) ?>">تعديل</a>
                                            <form method="POST" action="<?= e(url('/categories/delete')) ?>" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟');">
                                                <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
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
