<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<?php
    $entity = $category ?? [];
    $name = old('name', $entity['name'] ?? '');
    $slug = old('slug', $entity['slug'] ?? '');
    $icon = old('icon', $entity['icon'] ?? '');
    $description = old('description', $entity['description'] ?? '');
    $sortOrder = old('sort_order', $entity['sort_order'] ?? 0);
    $isActive = old('is_active', $entity ? (int) $entity['is_active'] : 1);
?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>
        <div class="split">
            <div class="card panel">
                <div class="toolbar">
                    <div>
                        <span class="badge"><?= $category ? 'تعديل قسم' : 'إضافة قسم' ?></span>
                        <h1 style="margin:10px 0 6px"><?= e($title) ?></h1>
                        <p class="muted" style="margin:0">اجعل اسم القسم واضحًا، واستخدم الأيقونة التي تريد ظهورها بجانب اسم القسم في الواجهة.</p>
                    </div>
                    <a class="btn btn-light" href="<?= e(url('/categories')) ?>">رجوع للقائمة</a>
                </div>

                <form method="POST" action="<?= e(url($formAction)) ?>">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                    <div class="form-grid">
                        <div>
                            <label>اسم القسم</label>
                            <input class="input" name="name" value="<?= e($name) ?>" placeholder="مثال: قسم المشاوي">
                        </div>
                        <div>
                            <label>الأيقونة</label>
                            <input class="input" name="icon" value="<?= e($icon) ?>" placeholder="🔥 أو 🍗 أو 🥤">
                        </div>
                        <div>
                            <label>Slug</label>
                            <input class="input" name="slug" value="<?= e($slug) ?>" placeholder="يُترك فارغًا ليتم توليده تلقائيًا">
                        </div>
                        <div>
                            <label>ترتيب العرض</label>
                            <input class="input" type="number" name="sort_order" value="<?= e((string) $sortOrder) ?>">
                        </div>
                        <div class="full">
                            <label>وصف مختصر</label>
                            <textarea class="textarea" name="description" placeholder="وصف اختياري للقسم يظهر لاحقًا إن رغبت بذلك"><?= e($description) ?></textarea>
                        </div>
                        <div class="full">
                            <label>حالة القسم</label>
                            <label class="checkbox-wrap"><input type="checkbox" name="is_active" value="1" <?= checked($isActive) ?>> تفعيل القسم وإظهاره داخل الموقع</label>
                        </div>
                    </div>

                    <div class="actions" style="margin-top:18px">
                        <button class="btn btn-primary" type="submit">حفظ البيانات</button>
                        <a class="btn btn-light" href="<?= e(url('/categories')) ?>">إلغاء</a>
                    </div>
                </form>
            </div>

            <div class="card panel">
                <h3 style="margin-top:0">نصائح سريعة</h3>
                <div class="meta-list">
                    <div class="meta-item">استخدم ترتيب العرض لتنظيم ظهور الأقسام داخل المنيو.</div>
                    <div class="meta-item">الأيقونة تُخزن كنص، لذلك يمكنك استخدام Emoji مباشرة.</div>
                    <div class="meta-item">إن تركت slug فارغًا سيتم توليده تلقائيًا من اسم القسم.</div>
                    <div class="meta-item">لا يمكن حذف القسم إذا كان يحتوي على أصناف.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
