<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?><div class="flash flash-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>

        <div class="card panel" style="margin-bottom:18px">
            <div class="toolbar">
                <div>
                    <span class="badge">إدارة الأصناف</span>
                    <h1 style="margin:10px 0 6px">الأصناف والوجبات</h1>
                    <p class="muted" style="margin:0">إجمالي الأصناف المحددة كأكثر طلبًا الآن: <strong><?= (int) $popularCount ?>/6</strong></p>
                </div>
                <div class="actions">
                    <a class="btn btn-primary" href="<?= e(url('/items/create')) ?>">+ إضافة صنف جديد</a>
                </div>
            </div>

            <form method="GET" action="<?= e(url('/items')) ?>" class="filter-grid">
                <div>
                    <label>بحث</label>
                    <input class="input" name="search" value="<?= e($filters['search'] ?? '') ?>" placeholder="اسم الصنف أو القسم">
                </div>
                <div>
                    <label>القسم</label>
                    <select class="select" name="category_id">
                        <option value="">كل الأقسام</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['id'] ?>" <?= selected($filters['category_id'] ?? '', $category['id']) ?>><?= e(($category['icon'] ? $category['icon'] . ' ' : '') . $category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-secondary" type="submit">تصفية</button>
                <a class="btn btn-light" href="<?= e(url('/items')) ?>">إعادة ضبط</a>
            </form>
        </div>

        <div class="card panel">
            <?php if (!$items): ?>
                <div class="empty-state">
                    <h3>لا توجد أصناف مطابقة</h3>
                    <p>أضف صنفًا جديدًا أو غيّر إعدادات التصفية الحالية.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الصنف</th>
                                <th>القسم</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>الأكثر طلبًا</th>
                                <th>الصورة</th>
                                <th>الترتيب</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= (int) $item['id'] ?></td>
                                    <td>
                                        <div style="font-weight:800"><?= e($item['icon']) ?> <?= e($item['name']) ?></div>
                                        <div class="mini"><?= e($item['short_description'] ?: 'بدون وصف مختصر') ?></div>
                                    </td>
                                    <td><span class="chip"><?= e(($item['category_icon'] ? $item['category_icon'] . ' ' : '') . $item['category_name']) ?></span></td>
                                    <td><?= e((string) $item['price']) ?></td>
                                    <td><span class="status <?= (int) $item['is_active'] === 1 ? 'active' : 'inactive' ?>"><?= (int) $item['is_active'] === 1 ? 'نشط' : 'مخفي' ?></span></td>
                                    <td><?= (int) $item['is_popular'] === 1 ? '<span class="status active">ضمن القائمة</span>' : '<span class="status inactive">لا</span>' ?></td>
                                    <td>
                                        <?php if (!empty($item['image_path'])): ?>
                                            <div class="thumb"><img src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['name']) ?>"></div>
                                        <?php else: ?>
                                            <div class="thumb mini">بدون صورة</div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= (int) $item['sort_order'] ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= e(url('/items/edit?id=' . (int) $item['id'])) ?>">تعديل</a>
                                            <form method="POST" action="<?= e(url('/items/delete')) ?>" onsubmit="return confirm('هل أنت متأكد من حذف هذا الصنف؟');">
                                                <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
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
