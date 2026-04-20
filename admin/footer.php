</main>
<?php
echo('<script>');
echo('var aboutUsText="'.$about.'"');
echo('</script>');
?>

    <footer class="footer" >
      <div class="container footer-grid">
        <div class="footer-brand">
          <div class="restaurant-logo">
            <img src="images/yellow-logo.png" alt="Logo" loading="lazy" />
          </div>
          <div>
            <h3>مطاعم الدار دارك</h3>
            <p>
              جميع الحقوق محفوظة لمطاعم الدار دارك. نسعد بخدمتكم وتقديم أشهى المأكولات التي تلبي تطلعاتكم وتناسب كافة الأذواق.
            </p>
          </div>
        </div>

        <div class="footer-links" id="contact">
          <div class="footer-box">
            <h4>روابط مهمة</h4>
            <a href="#home">الرئيسية</a>
            <a href="#menu">المنيو</a>
            <a href="#featured">الأكثر طلبًا</a>
            <a href="#gallery">المعرض</a>
          </div>

          <div class="footer-box">
            <h4>فروعنا</h4>
            <a href="https://maps.app.goo.gl/XtEDEkhzzXbAuYqJ8" target="_blank" rel="noopener">📍 فرع الدائري - 774488874</a>
            <a href="https://maps.app.goo.gl/UXRi7UXsRx7D8hJT7" target="_blank" rel="noopener">📍 فرع المعاين - 774488875</a>
          </div>

          <div class="footer-box">
            <h4>تواصل معنا</h4>
            <a onclick="aboutUs()">من نحن</a>
            <a href="<?=$contact_url?>">اتصل بنا</a>
            <a href="<?=$dev_url?>" target="_blank" rel="noopener">تصميم وتكويد: Z-Tech</a>
          </div>
        </div>
      </div>

      <div class="container footer-bottom">
        <p>© <span id="yearNow"><?php echo date('Y'); ?></span> جميع الحقوق محفوظة مطاعم الدار دارك.</p>
        <div class="footer-designer">
          <img src="images/ztech-logo.png" alt="Z-Tech" loading="lazy" />
          <span>تصميم وتكويد: <a href="<?=$dev_url?>" target="_blank" rel="noopener">Z-Tech</a></span>
        </div>
      </div>
    </footer>

    <a class="floating-whatsapp" href="<?=$whatsapp_url?>" target="_blank" rel="noopener" aria-label="واتساب">
      <span>💬</span>
    </a>

    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى">↑</button>
  </div>

  <script src="main.js" defer></script>
</body>
</html>