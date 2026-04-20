<?php
include 'data.php';
// echo('<script>');
// echo('aboutUs='.$about);
// echo('</script>');
?>
<section class="section section-about" id="about">
  <div class="container">
    <div class="about-card glass-card reveal">
      <span class="section-badge">قصتنا</span>
      <h2>الدار دارك: عنوان الضيافة والمذاق الأصيل</h2>
      <p>
        <?=$about?>
      </p>

      <div class="about-highlights">
        <div class="about-highlight">
          <strong>أصالة المذاق</strong>
          <span>نحافظ على الوصفات التقليدية التي تميز أطباقنا.</span>
        </div>
        <div class="about-highlight">
          <strong>خدمة راقية</strong>
          <span>فريق عمل مدرب لضمان راحتكم ورضاكم التام.</span>
        </div>
        <div class="about-highlight">
          <strong>أجواء عائلية</strong>
          <span>نوفر بيئة مريحة تناسب العائلات والأفراد على حد سواء.</span>
        </div>
      </div>
    </div>
  </div>
</section>