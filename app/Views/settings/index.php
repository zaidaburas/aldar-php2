<?php require APP_PATH . '/Views/layouts/header.php'; ?>
<?php require APP_PATH . '/Views/partials/admin-topbar.php'; ?>
<?php
    $values = $settings ?? [];
    $featuredSelected = (int) ($values['featured_item_id'] ?? 0);
?>
<div class="page">
    <div class="container">
        <?php if ($message = flash('success')): ?><div class="flash flash-success"><?= e($message) ?></div><?php endif; ?>
        <?php if ($message = flash('error')): ?><div class="flash flash-error"><?= e($message) ?></div><?php endif; ?>

        <div class="split">
            <div class="card panel">
                <div class="toolbar">
                    <div>
                        <span class="badge">الإعدادات العامة</span>
                        <h1 style="margin:10px 0 6px">نصوص وروابط الموقع</h1>
                        <p class="muted" style="margin:0">من هنا تتحكم بروابط الطلب والواتساب والتواصل ونص من نحن والوجبة المميزة.</p>
                    </div>
                </div>

                <form method="POST" action="<?= e(url('/settings/update')) ?>">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">

                    <div class="card panel" style="margin-bottom:18px">
                        <h3 style="margin-top:0">إعدادات عامة</h3>
                        <div class="form-grid">
                            <div>
                                <label>اسم الموقع</label>
                                <input class="input" name="site_title" value="<?= e($values['site_title'] ?? '') ?>">
                            </div>
                            <div>
                                <label>وصف الموقع</label>
                                <input class="input" name="site_description" value="<?= e($values['site_description'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="card panel" style="margin-bottom:18px">
                        <h3 style="margin-top:0">روابط ديناميكية</h3>
                        <div class="form-grid">
                            <div>
                                <label>رابط اطلب الآن</label>
                                <input class="input" name="order_now_url" value="<?= e($values['order_now_url'] ?? '') ?>" placeholder="#order أو رابط خارجي">
                            </div>
                            <div>
                                <label>رابط الواتساب</label>
                                <input class="input" name="whatsapp_url" value="<?= e($values['whatsapp_url'] ?? '') ?>" placeholder="https://wa.me/...">
                            </div>
                            <div class="full">
                                <label>رابط اتصل بنا</label>
                                <input class="input" name="contact_url" value="<?= e($values['contact_url'] ?? '') ?>" placeholder="tel:+... أو صفحة تواصل">
                            </div>
                        </div>
                    </div>

                    <div class="card panel" style="margin-bottom:18px">
                        <h3 style="margin-top:0">الهيرو والشريط العلوي</h3>
                        <div class="form-grid">
                            <div class="full">
                                <label>نص الشريط العلوي</label>
                                <input class="input" name="topbar_text" value="<?= e($values['topbar_text'] ?? '') ?>">
                            </div>
                            <div>
                                <label>عنوان الهيرو</label>
                                <input class="input" name="hero_title" value="<?= e($values['hero_title'] ?? '') ?>">
                            </div>
                            <div class="full">
                                <label>وصف الهيرو</label>
                                <textarea class="textarea" name="hero_description"><?= e($values['hero_description'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card panel" style="margin-bottom:18px">
                        <h3 style="margin-top:0">من نحن والوجبة المميزة</h3>
                        <div class="form-grid">
                            <div class="full">
                                <label>نص من نحن</label>
                                <textarea class="textarea" name="about_text"><?= e($values['about_text'] ?? '') ?></textarea>
                            </div>
                            <div class="full">
                                <label>الوجبة المميزة</label>
                                <select class="select" name="featured_item_id">
                                    <option value="">بدون اختيار</option>
                                    <?php foreach ($featuredItems as $featuredItem): ?>
                                        <option value="<?= (int) $featuredItem['id'] ?>" <?= selected($featuredSelected, $featuredItem['id']) ?>><?= e(($featuredItem['category_icon'] ? $featuredItem['category_icon'] . ' ' : '') . $featuredItem['name'] . ' — ' . $featuredItem['category_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="mini" style="margin-top:8px">سيتم عرض وجبة واحدة فقط في قسم الوجبة المميزة.</div>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn btn-primary" type="submit">حفظ الإعدادات</button>
                    </div>
                </form>
            </div>

            <div class="card panel">
                <h3 style="margin-top:0">ملخص سريع</h3>
                <div class="meta-list">
                    <div class="meta-item">يمكنك تغيير الروابط بدون تعديل الكود.</div>
                    <div class="meta-item">الوجبة المميزة تُختار من الأصناف المحفوظة فقط.</div>
                    <div class="meta-item">إذا حذفت صنفًا كان مميزًا، يتم إلغاء اختياره تلقائيًا.</div>
                    <div class="meta-item">هذه الصفحة جاهزة للربط مع الواجهة الأمامية لاحقًا.</div>
                </div>

                <div class="card panel" style="margin-top:18px">
                    <h4 style="margin-top:0">المفاتيح المحفوظة</h4>
                    <div class="chips">
                        <span class="chip">site_title</span>
                        <span class="chip">site_description</span>
                        <span class="chip">order_now_url</span>
                        <span class="chip">whatsapp_url</span>
                        <span class="chip">contact_url</span>
                        <span class="chip">topbar_text</span>
                        <span class="chip">hero_title</span>
                        <span class="chip">hero_description</span>
                        <span class="chip">about_text</span>
                        <span class="chip">featured_item_id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APP_PATH . '/Views/layouts/footer.php'; ?>
