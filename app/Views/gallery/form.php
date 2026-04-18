<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<?php
    $entity = $image ?? [];
    $titleValue = old('title', $entity['title'] ?? '');
    $sortOrder = old('sort_order', $entity['sort_order'] ?? 0);
    $isActive = old('is_active', $entity ? (int) $entity['is_active'] : 1);
    $imagePath = $entity['image_path'] ?? null;
?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>
        <div class="split">
            <div class="card panel">
                <div class="toolbar">
                    <div>
                        <span class="badge"><?= $image ? 'تعديل صورة' : 'إضافة صورة' ?></span>
                        <h1 style="margin:10px 0 6px"><?= e($title) ?></h1>
                        <p class="muted" style="margin:0">يمكنك استبدال الصورة الحالية بصورة أخرى في أي وقت.</p>
                    </div>
                    <a class="btn btn-light" href="<?= e(url('/gallery')) ?>">رجوع للقائمة</a>
                </div>

                <form method="POST" action="<?= e(url($formAction)) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                    <div class="form-grid">
                        <div>
                            <label>عنوان الصورة</label>
                            <input class="input" name="title" value="<?= e($titleValue) ?>" placeholder="مثال: طبق مشويات مميز">
                        </div>
                        <div>
                            <label>ترتيب العرض</label>
                            <input class="input" type="number" name="sort_order" value="<?= e((string) $sortOrder) ?>">
                        </div>
                        <div class="full">
                            <label>الصورة</label>
                            <input class="input" type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/*">
                            <?php if ($imagePath): ?>
                                <div style="margin-top:12px; display:flex; gap:14px; align-items:center">
                                    <div class="thumb"><img src="<?= e(upload_url($imagePath)) ?>" alt="<?= e($titleValue) ?>"></div>
                                    <div class="mini">الصورة الحالية: <?= e($imagePath) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="full">
                            <label>الحالة</label>
                            <label class="checkbox-wrap"><input type="checkbox" name="is_active" value="1" <?= checked($isActive) ?>> عرض هذه الصورة في المعرض</label>
                        </div>
                    </div>
                    <div class="actions" style="margin-top:18px">
                        <button class="btn btn-primary" type="submit">حفظ البيانات</button>
                        <a class="btn btn-light" href="<?= e(url('/gallery')) ?>">إلغاء</a>
                    </div>
                </form>
            </div>
            <div class="card panel">
                <h3 style="margin-top:0">إرشادات</h3>
                <div class="meta-list">
                    <div class="meta-item">يفضل استخدام صور واضحة وعالية الجودة.</div>
                    <div class="meta-item">الترتيب الأصغر يظهر أولًا في المعرض.</div>
                    <div class="meta-item">يمكن إخفاء الصورة دون حذفها عبر تعطيل حالتها.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
