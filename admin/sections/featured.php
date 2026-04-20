<?php
include 'data.php';
// $featuredItems = [
//   [ 'icon' => '🔥', 'title' => 'مشويات الدار إسبيشل', 'desc' => 'تشكيلة فاخرة من اللحوم والدجاج الطازج، متبلة بخلطة الدار السرية ومشوية على الفحم لتصلك طرية وغنية بنكهة الشواء الأصيلة.', 'tag' => 'الأكثر شهرة' ],
//   [ 'icon' => '🍗', 'title' => 'حبه بروست', 'desc' => 'دجاج طازج متبل بعناية، يُقلى بضغط وحرارة مثالية ليمنحك قرمشة ذهبية من الخارج وطراوة من الداخل، يُقدم مع البطاطس والمثومة.', 'tag' => 'طلب سريع' ],
//   [ 'icon' => '🌯', 'title' => 'صحن شوارما إسبيشل', 'desc' => 'شرائح دجاج محمرة ومقطعة طازجة من السيخ، تُقدم مع البطاطس المقلية، تشكيلة من المخللات المقرمشة، وصلصة الثومية الغنية.', 'tag' => 'مفضل العملاء' ],
//   [ 'icon' => '🐟', 'title' => 'جمبري جامبو', 'desc' => 'حبات جمبري بحجم جامبو طازجة، تُتبل ببهارات بحرية خاصة وتُطهى بعناية لتحتفظ بعصارتها، لتستمتع بمذاق بحري غني وفريد.', 'tag' => 'بحري' ],
//   [ 'icon' => '🥤', 'title' => 'عصير الدار', 'desc' => 'كوكتيل طبيعي محضر من فواكه موسمية طازجة مختارة بعناية، يُعصر يومياً ليمنحك انتعاشاً حقيقياً وطاقة طبيعية.', 'tag' => 'منعش' ],
//   [ 'icon' => '🍰', 'title' => 'كنافة (بالقشطة - نوتيلا)', 'desc' => 'خيوط كنافة ذهبية مقرمشة مخبوزة بالسمن البلدي، محشوة بالقشطة الطازجة أو شوكولاتة نوتيلا الغنية، لتكمل بها وجبتك.', 'tag' => 'حلويات' ]
// ];

function renderFeaturedItems($items) {
    foreach ($items as $item) {
        echo '
        <article class="feature-card reveal">
            <div class="feature-icon">' . htmlspecialchars($item['icon']) . '</div>
            <h3>' . htmlspecialchars($item['title']) . '</h3>
            <p>' . htmlspecialchars($item['desc']) . '</p>
            <span class="feature-tag">' . htmlspecialchars($item['tag']) . '</span>
        </article>';
    }
}
?>
<section class="section section-featured" id="featured">
  <div class="container">
    <div class="section-head reveal">
      <span class="section-badge">الأكثر طلبًا</span>
      <h2>أطباقنا الأكثر طلباً وشعبية</h2>
      <p>
        اكتشف قائمة من أشهى الأطباق التي يفضلها زبائننا، والمحضرة بأيدي أمهر الطهاة لضمان تجربة طعام لا تُنسى.
      </p>
    </div>

    <div class="featured-grid" id="featuredGrid">
        <?php renderFeaturedItems($featuredItems); ?>
    </div>
  </div>
</section>