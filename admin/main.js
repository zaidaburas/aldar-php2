


// const slidesData7777 = Array.from({ length: 34 }, (_, i) => {
//   const num = String(i + 1).padStart(2, "0");
//   return {
//     image: `images/slide/slide${num}.jpg`,
//     title: `صورة ${i + 1} من معرض الوجبات`,
//     subtitle: "مطاعم الدار دارك"
//   };
// });

// const adsSlideData7777 = Array.from({ length: 34 }, (_, i) => {
//   const num = String(i + 1).padStart(2, "0");
//   return {
//     image: `images/slide/slide${num}.jpg`,
//     title: `صورة ${i + 1} من معرض الوجبات`,
//     subtitle: "مطاعم الدار دارك",
//     tag: "مطاعم الدار دارك"
//   };
// });

const statCategories = document.getElementById("statCategories");
const statItems = document.getElementById("statItems");
const featuredGrid = document.getElementById("featuredGrid");
const menuTabs = document.getElementById("menuTabs");
const menuResults = document.getElementById("menuResults");
const menuSearch = document.getElementById("menuSearch");
const menuSummary = document.getElementById("menuSummary");
const yearNow = document.getElementById("yearNow");



const adsSlideImage = document.getElementById("adsSlideImage");
const adsSlideTitle = document.getElementById("adsSlideTitle");
const adsSlideSubTitle = document.getElementById("adsSlideSubTitle");
const adsSlideTag = document.getElementById("adsSlideTag");

const galleryImage = document.getElementById("galleryImage");
const galleryTitle = document.getElementById("galleryTitle");
const gallerySubtitle = document.getElementById("gallerySubtitle");
const galleryCounter = document.getElementById("galleryCounter");
const galleryThumbs = document.getElementById("galleryThumbs");
const galleryProgressBar = document.getElementById("galleryProgressBar");
const prevSlide = document.getElementById("prevSlide");
const nextSlide = document.getElementById("nextSlide");

const header = document.getElementById("header");
const backToTop = document.getElementById("backToTop");
const menuToggle = document.getElementById("menuToggle");
const mobileNav = document.getElementById("mobileNav");

let activeCategory = menuData[0].title;
let currentSlideIndex = 0;
let currentHeroSlideIndex = 0;
let sliderInterval = null;

function getTotalItems(data) {
  return data.reduce((sum, category) => sum + category.items.length, 0);
}

function updateStats() {
  statCategories.textContent = menuData.length;
  statItems.textContent = getTotalItems(menuData);
  menuSummary.textContent = `${menuData.length} قسم / ${getTotalItems(menuData)} صنف`;
  yearNow.textContent = new Date().getFullYear();
}

function renderFeaturedItems() {
  featuredGrid.innerHTML = featuredItems.map(item => `
    <article class="feature-card reveal">
      <div class="feature-icon">${item.icon}</div>
      <h3>${item.title}</h3>
      <p>${item.desc}</p>
      <span class="feature-tag">${item.tag}</span>
    </article>
  `).join("");
}

function renderMenuTabs() {
  const tabs = [
    { title: "الكل", icon: "📋" },
    ...menuData.map(category => ({
      title: category.title,
      icon: category.icon
    }))
  ];

  menuTabs.innerHTML = tabs.map(tab => `
    <button
      class="menu-tab ${activeCategory === tab.title ? "active" : ""}"
      data-category="${tab.title}"
      type="button"
    >
      ${tab.icon} ${tab.title}
    </button>
  `).join("");
}

function escapeRegExp(text) {
  return text.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function highlightText(text, keyword) {
  if (!keyword) return text;
  const safeKeyword = escapeRegExp(keyword);
  const regex = new RegExp(`(${safeKeyword})`, "gi");
  return text.replace(regex, "<mark>$1</mark>");
}

function getFilteredMenuData(query = "") {
  const normalizedQuery = query.trim().toLowerCase();

  let data = menuData;

  if (activeCategory !== "الكل") {
    data = data.filter(category => category.title === activeCategory);
  }

  if (!normalizedQuery) {
    return data;
  }

  return data
    .map(category => {
      const categoryMatch = category.title.toLowerCase().includes(normalizedQuery);
      const matchedItems = category.items.filter(item =>
        item.toLowerCase().includes(normalizedQuery)
      );

      if (categoryMatch) {
        return category;
      }

      if (matchedItems.length > 0) {
        return {
          ...category,
          items: matchedItems
        };
      }

      return null;
    })
    .filter(Boolean);
}

function renderMenuResults(query = "") {
  const filteredData = getFilteredMenuData(query);
  const totalItems = getTotalItems(filteredData);

  menuSummary.textContent = `${filteredData.length} قسم / ${totalItems} صنف`;

  if (!filteredData.length) {
    menuResults.innerHTML = `
      <div class="empty-state">
        <h3>لا توجد نتائج</h3>
        <p>جرّب كلمة بحث مختلفة أو اختر قسمًا آخر من التبويبات.</p>
      </div>
    `;
    return;
  }

  menuResults.innerHTML = filteredData.map(category => `
    <section class="menu-category-block reveal">
      <div class="menu-category-head">
        <div class="menu-category-title">
          <div class="menu-category-icon">${category.icon}</div>
          <div>
            <h3>${highlightText(category.title, query)}</h3>
            <p>اكتشف أشهى الأصناف في هذا القسم واختر وجبتك المفضلة</p>
          </div>
        </div>
        <div class="menu-category-count">${category.items.length} صنف</div>
      </div>

      <div class="menu-items-grid">
        ${category.items.map(item => `
          <article class="menu-item-card">
            <div class="menu-item-bullet"></div>
            <span>${highlightText(item, query)}</span>
          </article>
        `).join("")}
      </div>
    </section>
  `).join("");

  observeRevealElements();
}

function renderGalleryThumbs() {
  galleryThumbs.innerHTML = gallerySlideData.map((slide, index) => `
    <button
      type="button"
      class="${index === currentSlideIndex ? "active" : ""}"
      data-index="${index}"
      aria-label="الصورة ${index + 1}"
    >
      ${index + 1}
    </button>
  `).join("");
}

function updateGallery() {
  const current = gallerySlideData[currentSlideIndex];
  const currentHero = adsSlideData[currentHeroSlideIndex];

  galleryImage.src = current.image;
  galleryImage.alt = current.title;
  galleryTitle.textContent = current.title;
  gallerySubtitle.textContent = current.subtitle;
  galleryCounter.textContent = `${currentSlideIndex + 1} / ${gallerySlideData.length}`;
  galleryProgressBar.style.width = `${((currentSlideIndex + 1) / gallerySlideData.length) * 100}%`;

  adsSlideImage.src = currentHero.image;
  adsSlideTitle.textContent = currentHero.title;
  adsSlideSubTitle.textContent = currentHero.subtitle;
  adsSlideTag.textContent = currentHero.tag;

  [...galleryThumbs.querySelectorAll("button")].forEach((btn, index) => {
    btn.classList.toggle("active", index === currentSlideIndex);
  });
}

function goToSlide(index,hero) {
  currentSlideIndex = (index + gallerySlideData.length) % gallerySlideData.length;
  currentHeroSlideIndex = (hero + adsSlideData.length) % adsSlideData.length;
  updateGallery();
}

function nextGallerySlide() {
  goToSlide(currentSlideIndex + 1,currentHeroSlideIndex+1);
}

function prevGallerySlide() {
  goToSlide(currentSlideIndex - 1,currentHeroSlideIndex-1);
}

function startSlider() {
  stopSlider();
  sliderInterval = setInterval(() => {
    nextGallerySlide();
  }, 4000);
}

function stopSlider() {
  if (sliderInterval) {
    clearInterval(sliderInterval);
    sliderInterval = null;
  }
}

function handleHeaderOnScroll() {
  if (window.scrollY > 40) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }

  if (window.scrollY > 350) {
    backToTop.classList.add("show");
  } else {
    backToTop.classList.remove("show");
  }
}

function setupScrollReveal() {
  observeRevealElements();
}

let revealObserver = null;

function observeRevealElements() {
  const elements = document.querySelectorAll(".reveal");

  if (!("IntersectionObserver" in window)) {
    elements.forEach(el => el.classList.add("show"));
    return;
  }

  if (!revealObserver) {
    revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("show");
          revealObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12
    });
  }

  elements.forEach(el => {
    if (!el.classList.contains("show")) {
      revealObserver.observe(el);
    }
  });
}

function setupEvents() {
  menuTabs.addEventListener("click", (e) => {
    const tab = e.target.closest(".menu-tab");
    if (!tab) return;

    activeCategory = tab.dataset.category;
    renderMenuTabs();
    renderMenuResults(menuSearch.value);
  });

  menuSearch.addEventListener("input", (e) => {
    renderMenuResults(e.target.value);
  });

  nextSlide.addEventListener("click", () => {
    nextGallerySlide();
    startSlider();
  });

  prevSlide.addEventListener("click", () => {
    prevGallerySlide();
    startSlider();
  });

  galleryThumbs.addEventListener("click", (e) => {
    const btn = e.target.closest("button");
    if (!btn) return;

    const index = Number(btn.dataset.index);
    goToSlide(index);
    startSlider();
  });

  galleryImage.addEventListener("mouseenter", stopSlider);
  galleryImage.addEventListener("mouseleave", startSlider);

  adsSlideImage.addEventListener("mouseenter", stopSlider);
  adsSlideImage.addEventListener("mouseleave", startSlider);

  backToTop.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });

  function closeMobileMenu() {
    mobileNav.classList.remove("open");
    document.body.classList.remove("mobile-menu-open");
    menuToggle.setAttribute("aria-expanded", "false");
  }

  function openMobileMenu() {
    mobileNav.classList.add("open");
    document.body.classList.add("mobile-menu-open");
    menuToggle.setAttribute("aria-expanded", "true");
  }

  menuToggle.addEventListener("click", () => {
    const isOpen = mobileNav.classList.contains("open");
    if (isOpen) {
      closeMobileMenu();
    } else {
      openMobileMenu();
    }
  });

  mobileNav.querySelectorAll("a").forEach(link => {
    link.addEventListener("click", () => {
      closeMobileMenu();
    });
  });

  document.addEventListener("click", (e) => {
    const clickedInsideMenu = mobileNav.contains(e.target);
    const clickedToggle = menuToggle.contains(e.target);

    if (!clickedInsideMenu && !clickedToggle && mobileNav.classList.contains("open")) {
      closeMobileMenu();
    }
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 1024) {
      closeMobileMenu();
    }
  });

  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && mobileNav.classList.contains("open")) {
      closeMobileMenu();
    }
  });


  window.addEventListener("scroll", handleHeaderOnScroll);
  window.addEventListener("resize", handleHeaderOnScroll);
}

function init() {
  updateStats();
  // renderFeaturedItems();
  renderMenuTabs();
  renderMenuResults();
  renderGalleryThumbs();
  updateGallery();
  setupEvents();
  setupScrollReveal();
  handleHeaderOnScroll();
  startSlider();
}

document.addEventListener("DOMContentLoaded", init);

function showDialog({
  title = "تنبيه",
  subtitle = "",
  message = "",
  content = "",
  icon = "💡",
  confirmText = "موافق",
  cancelText = "إلغاء",
  type = "primary", // primary | danger
  showCancel = false,
  closeOnBackdrop = true,
  onConfirm = null,
  onCancel = null
} = {}) {
  // حذف أي dialog قديم مفتوح
  const oldDialog = document.getElementById("appDialogBackdrop");
  if (oldDialog) {
    oldDialog.remove();
  }

  const backdrop = document.createElement("div");
  backdrop.className = "dialog-backdrop";
  backdrop.id = "appDialogBackdrop";

  const confirmClass = type === "danger" ? "dialog-btn-danger" : "dialog-btn-primary";

  backdrop.innerHTML = `
    <div class="dialog-box" role="dialog" aria-modal="true" aria-labelledby="appDialogTitle" aria-describedby="appDialogDesc">
      <div class="dialog-header">
        <div class="dialog-icon">${icon}</div>

        <div class="dialog-title-wrap">
          <h3 class="dialog-title" id="appDialogTitle">${title}</h3>
          ${subtitle ? `<p class="dialog-subtitle">${subtitle}</p>` : ""}
        </div>

        <button class="dialog-close" type="button" aria-label="إغلاق">×</button>
      </div>

      <div class="dialog-body">
        ${message ? `<p class="dialog-message" id="appDialogDesc">${message}</p>` : ""}
        ${content ? `<div class="dialog-content">${content}</div>` : ""}
      </div>

      <div class="dialog-footer">
        ${showCancel ? `<button type="button" class="dialog-btn dialog-btn-secondary" data-action="cancel">${cancelText}</button>` : ""}
        <button type="button" class="dialog-btn ${confirmClass}" data-action="confirm">${confirmText}</button>
      </div>
    </div>
  `;

  document.body.appendChild(backdrop);
  document.body.classList.add("dialog-open");

  const dialogBox = backdrop.querySelector(".dialog-box");
  const closeBtn = backdrop.querySelector(".dialog-close");
  const confirmBtn = backdrop.querySelector('[data-action="confirm"]');
  const cancelBtn = backdrop.querySelector('[data-action="cancel"]');

  function closeDialog() {
    backdrop.classList.remove("show");
    document.body.classList.remove("dialog-open");

    setTimeout(() => {
      backdrop.remove();
    }, 220);
  }

  function handleConfirm() {
    if (typeof onConfirm === "function") {
      onConfirm(closeDialog);
    } else {
      closeDialog();
    }
  }

  function handleCancel() {
    if (typeof onCancel === "function") {
      onCancel(closeDialog);
    } else {
      closeDialog();
    }
  }

  closeBtn.addEventListener("click", handleCancel);

  if (confirmBtn) {
    confirmBtn.addEventListener("click", handleConfirm);
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", handleCancel);
  }

  if (closeOnBackdrop) {
    backdrop.addEventListener("click", (e) => {
      if (e.target === backdrop) {
        handleCancel();
      }
    });
  }

  document.addEventListener("keydown", function escHandler(e) {
    if (e.key === "Escape") {
      handleCancel();
      document.removeEventListener("keydown", escHandler);
    }
  });

  requestAnimationFrame(() => {
    backdrop.classList.add("show");
  });

  setTimeout(() => {
    const focusTarget = confirmBtn || closeBtn || dialogBox;
    focusTarget.focus?.();
  }, 50);

  return {
    close: closeDialog
  };
}

function aboutUs(){
  return showDialog({
    title: "حول",
    message: aboutUsText,
    icon: "❔",
    confirmText: "حسناً"
  });
  
}

