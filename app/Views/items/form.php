<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<?php
    $entity = $item ?? [];
    $categoryId = old('category_id', $entity['category_id'] ?? '');
    $name = old('name', $entity['name'] ?? '');
    $slug = old('slug', $entity['slug'] ?? '');
    $shortDescription = old('short_description', $entity['short_description'] ?? '');
    $description = old('description', $entity['description'] ?? '');
    $price = old('price', $entity['price'] ?? '');
    $icon = old('icon', $entity['icon'] ?? '');
    $sortOrder = old('sort_order', $entity['sort_order'] ?? 0);
    $isPopular = old('is_popular', $entity ? (int) $entity['is_popular'] : 0);
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
                        <span class="badge"><?= $item ? 'تعديل صنف' : 'إضافة صنف' ?></span>
                        <h1 style="margin:10px 0 6px"><?= e($title) ?></h1>
                        <p class="muted" style="margin:0">املأ بيانات الصنف، ويمكنك تعيينه كأكثر طلبًا مباشرة من هذا النموذج.</p>
                    </div>
                    <a class="btn btn-light" href="<?= e(url('/items')) ?>">رجوع للقائمة</a>
                </div>

                <form method="POST" action="<?= e(url($formAction)) ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                    <div class="form-grid">
                        <div>
                            <label>القسم</label>
                            <select class="select" name="category_id">
                                <option value="">اختر القسم</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= (int) $category['id'] ?>" <?= selected($categoryId, $category['id']) ?>><?= e(($category['icon'] ? $category['icon'] . ' ' : '') . $category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label>اسم الصنف</label>
                            <input class="input" name="name" value="<?= e($name) ?>" placeholder="مثال: مشويات الدار إسبيشل">
                        </div>
                        <div>
                            <label>الأيقونة</label>
                            <input class="input" name="icon" value="<?= e($icon) ?>" placeholder="اختياري - يمكن تركه فارغًا">
                        </div>
                        <div>
                            <label>السعر</label>
                            <input class="input" name="price" value="<?= e((string) $price) ?>" placeholder="مثال: 25.00">
                        </div>
                        <div class="full">
                            <label>الوصف المختصر</label>
                            <input class="input" name="short_description" value="<?= e($shortDescription) ?>" placeholder="وصف قصير يظهر في الكروت أو قسم الأكثر طلبًا">
                        </div>
                        <div class="full">
                            <label>الوصف الكامل</label>
                            <textarea class="textarea" name="description" placeholder="تفاصيل إضافية عن الصنف أو مكوناته"><?= e($description) ?></textarea>
                        </div>
                        <div>
                            <label>Slug</label>
                            <input class="input" name="slug" value="<?= e($slug) ?>" placeholder="اختياري - يتولد تلقائيًا عند تركه فارغًا">
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
                                    <div class="thumb"><img src="<?= e(upload_url($imagePath)) ?>" alt="<?= e($name) ?>"></div>
                                    <div class="mini">الصورة الحالية: <?= e($imagePath) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label>الحالة</label>
                            <label class="checkbox-wrap"><input type="checkbox" name="is_active" value="1" <?= checked($isActive) ?>> الصنف متاح ويظهر في الموقع</label>
                        </div>
                        <div>
                            <label>الأكثر طلبًا</label>
                            <label class="checkbox-wrap"><input type="checkbox" name="is_popular" value="1" <?= checked($isPopular) ?>> إضافته إلى قسم الأكثر طلبًا (بحد أقصى 6)</label>
                        </div>
                    </div>

                    <div class="actions" style="margin-top:18px">
                        <button class="btn btn-primary" type="submit">حفظ البيانات</button>
                        <a class="btn btn-light" href="<?= e(url('/items')) ?>">إلغاء</a>
                    </div>
                </form>
            </div>

            <div class="card panel">
                <h3 style="margin-top:0">إرشادات مهمة</h3>
                <div class="meta-list">
                    <div class="meta-item">حد قسم الأكثر طلبًا هو 6 أصناف فقط.</div>
                    <div class="meta-item">يمكنك إخفاء الصنف عند النفاد عبر تعطيل حالة الصنف بدل حذفه.</div>
                    <div class="meta-item">الصور المسموحة: JPG, PNG, WEBP بحد أقصى 5MB.</div>
                    <div class="meta-item">الوصف المختصر هو الأنسب للعرض في الكروت والواجهة.</div>
                    <div class="meta-item">إن تركت slug فارغًا سيتم إنشاؤه تلقائيًا.</div>
                </div>

                <?php if ($item): ?>
                    <div class="card panel danger-zone" style="margin-top:18px">
                        <h4 style="margin-top:0">تنبيه</h4>
                        <p class="mini" style="margin:0">عند رفع صورة جديدة سيتم استبدال الصورة القديمة تلقائيًا.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
