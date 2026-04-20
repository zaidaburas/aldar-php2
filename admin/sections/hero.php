<?php
include 'data.php';
// $adsSlideData=[];
// for ($i=1; $i < 8; $i++) { 
//     $adsSlideData[$i]=[
//         'image'=>'images/slide/slide'.($i<10?('0'.$i):($i)).'.jpg',
//         'title'=>'مكونات طازجة، وصفات أصلية، ومذاق فريد'.$i.'',
//         'subtitle'=>'نقدم لك قائمة طعام متكاملة محضرة بوصفاتنا الخاصة ومكوناتنا الطازجة، لتعيش تجربة طعام تليق بك.'.$i.'',
//         'tag'=>'مطاعم الدار دارك'.$i.''
//     ];
// }


function renderHeroSlideItems($adsSlideData) {
    echo('<script>');
    echo 'adsSlideData = Array();';
    foreach ($adsSlideData as $key => $value) {
        echo 'val={ title:"'.$value["title"].'", subtitle:"'.$value["subtitle"].'", image:"'.$value["image"].'", tag:"'.$value["tag"].'" };';
        echo 'adsSlideData.push(val);';
    }
    echo '</script>';
}
renderHeroSlideItems($adsSlideData);
?>
<section class="hero" id="home">
  <div class="hero-bg"></div>
  <div class="container hero-grid">
    <div class="hero-content reveal">
      <span class="hero-badge">مذاق أصيل وجودة لا تُضاهى</span>
      <h1>ألذ الوجبات اليمنية والعربية<br />بمذاق أصيل يعكس عراقة ضيافتنا</h1>
      <p>
        استمتع بتشكيلة واسعة من أشهى المأكولات، واكتشف طعم البروست المقرمش، والمشاوي الطازجة، والمأكولات البحرية، والشاورما، بالإضافة إلى العصائر الطبيعية والحلويات اللذيذة.
      </p>

      <div class="hero-actions-row">
        <a href="#order" class="btn btn-primary">اطلب الآن</a>
        <a href="#menu" class="btn btn-ghost">تصفح المنيو</a>
      </div>

      <div class="hero-stats" id="heroStats">
        <div class="stat-card">
          <strong id="statCategories">0</strong>
          <span>قسم متنوع</span>
        </div>
        <div class="stat-card">
          <strong id="statItems">0</strong>
          <span>صنف مختلف</span>
        </div>
        <div class="stat-card">
          <strong>34</strong>
          <span>صورة في المعرض</span>
        </div>
      </div>
    </div>

    <div class="hero-visual reveal">
      <div class="hero-visual-card glass-card">
        <div class="hero-visual-media">
          <img id="adsSlideImage" src="images/restaurant-logo.png" alt="مطاعم الدار دارك" loading="eager" />
        </div>
        <div class="hero-visual-body">
          <span class="mini-badge" id="adsSlideTag">مطاعم الدار دارك</span>
          <h2 id="adsSlideTitle">مكونات طازجة، وصفات أصلية، ومذاق فريد</h2>
          <p id="adsSlideSubTitle">
            نقدم لك قائمة طعام متكاملة محضرة بوصفاتنا الخاصة ومكوناتنا الطازجة، لتعيش تجربة طعام تليق بك.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>