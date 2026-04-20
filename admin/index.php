<?php
// ===================== بيانات المنيو =====================


// ============== العناصر المميزة ==============

// .reveal { opacity: 1 !important; transform: none !important; }

// $filteredMenuData = filterMenuData($menuData, $activeTab, $searchQuery);
// $totalFilteredItems = getTotalItems($filteredMenuData);
// $totalCategories = count($menuData);
// $totalAllItems = getTotalItems($menuData);

// ============== تضمين القوالب ==============

// <style>
//     .reveal { opacity: 1 !important; transform: none !important; }
// </style>

// include 'data.php';
include 'header.php';
include 'sections/hero.php';
include 'sections/featured.php';
include 'sections/gallery.php';
include 'sections/menu.php';
include 'sections/order.php';
include 'sections/app.php';
include 'sections/about.php';
include 'footer.php';
// include 'data.php';
?>
<?php


// slidesData = Array.from({ length: 34 }, (_, i) => {
//   const num = String(i + 1).padStart(2, "0");
//   return {
//     image: `images/slide/slide${num}.jpg`,
//     title: `صورة ${i + 1} من معرض الوجبات`,
//     subtitle: "مطاعم الدار دارك"
//   };
// });


//   {
//     title: "قسم البروست",
//     icon: "🍗",
//     items: [
//       "حبه بروست",
//       "نص بروست",
//       "ربع بروست",
//       "شبس - ثوم"
//     ]
//   },
?>