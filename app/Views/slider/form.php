<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<?php
    $entity = $slide ?? [];
    $titleValue = old('title', $entity['title'] ?? '');
    $subtitleValue = old('subtitle', $entity['subtitle'] ?? '');
    $buttonText = old('button_text', $entity['button_text'] ?? '');
    $linkUrl = old('link_url', $entity['link_url'] ?? '');
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
                        <span class="badge"><?= $slide ? 'تعديل شريحة' : 'إضافة شريحة' ?></span>
                        <h1 style="margin:10px 0 6px"><?= e($title) ?></h1>
                        <p class="muted" style="margin:0">الصورة مطلوبة، ويمكنك إضافة عنوان فرعي ونص زر ورابط عند الحاجة.</p>
                    </div>
                    <a class="btn btn-light" href="<?= e(url('/slider')) ?>">رجوع للقائمة</a>
                </div>

                <form method="POST" action="<?= e(url($formAction)) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                    <div class="form-grid">
                        <div>
                            <label>عنوان الشريحة</label>
                            <input class="input" name="title" value="<?= e($titleValue) ?>" placeholder="مثال: عروض نهاية الأسبوع">
                        </div>
                        <div>
                            <label>ترتيب العرض</label>
                            <input class="input" type="number" name="sort_order" value="<?= e((string) $sortOrder) ?>">
                        </div>
                        <div class="full">
                            <label>النص الفرعي</label>
                            <textarea class="textarea" name="subtitle" placeholder="وصف قصير يظهر داخل الشريحة"><?= e($subtitleValue) ?></textarea>
                        </div>
                        <div>
                            <label>نص الزر</label>
                            <input class="input" name="button_text" value="<?= e($buttonText) ?>" placeholder="مثال: اطلب الآن">
                        </div>
                        <div>
                            <label>الرابط</label>
                            <input class="input" name="link_url" value="<?= e($linkUrl) ?>" placeholder="مثال: https:// أو #menu">
                        </div>
                        <div class="full">
                            <label>صورة الشريحة</label>
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
                            <label class="checkbox-wrap"><input type="checkbox" name="is_active" value="1" <?= checked($isActive) ?>> تفعيل هذه الشريحة في الواجهة</label>
                        </div>
                    </div>
                    <div class="actions" style="margin-top:18px">
                        <button class="btn btn-primary" type="submit">حفظ البيانات</button>
                        <a class="btn btn-light" href="<?= e(url('/slider')) ?>">إلغاء</a>
                    </div>
                </form>
            </div>
            <div class="card panel">
                <h3 style="margin-top:0">ملاحظات</h3>
                <div class="meta-list">
                    <div class="meta-item">يُفضّل استخدام صورة أفقية مناسبة للواجهة الرئيسية.</div>
                    <div class="meta-item">يمكن ترك نص الزر والرابط فارغين إذا كانت الشريحة للعرض فقط.</div>
                    <div class="meta-item">ترتيب العرض الأصغر يظهر أولاً.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
