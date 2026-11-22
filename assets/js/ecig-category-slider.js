$ = jQuery;

$(document).ready(function () {
  document.querySelectorAll(".ecig-cat-wrap").forEach((wrapper) => {
    if (wrapper.dataset.init) return;
    wrapper.dataset.init = true;

    const tabs = wrapper.querySelectorAll(".ecig-tab");
    const tabsEl = wrapper.querySelector(".ecig-tabs");
    const productEl = wrapper.querySelector(".ecig-products");
    const skeleton = wrapper.querySelector(".ecig-skeleton");
    const wrap = wrapper.querySelector(".ecig-products .swiper-wrapper"); // FIXED

    let activeIndex = 0;
    let swiper;

    // Tabs swiper
    const tabsSwiper = new Swiper(tabsEl, {
      slidesPerView: "auto",
      freeMode: true,
      spaceBetween: 8,
    });

    function setActive(index) {
      activeIndex = index;

      tabs.forEach((t) => t.classList.remove("active"));
      tabs[index].classList.add("active");

      tabsSwiper.slideTo(index);
      loadCat(tabs[index].dataset.cat);
    }

    function loadCat(catId) {
      skeleton.style.display = "flex";
      productEl.style.display = "none";

      fetch(ecigCat.ajax, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=ecig_load_cat_products&cat=${catId}&limit=${wrapper.dataset.limit}`,
      })
        .then((r) => r.text())
        .then((html) => {
          wrap.innerHTML = html;

          if (swiper) swiper.destroy(true, true);

          productEl.style.display = "block"; // FIXED TIMING

          swiper = new Swiper(productEl, {
            slidesPerView: 2.54,
            speed: 800,
            spaceBetween: 8,
            freeMode: {
              enabled: true,
              momentum: true,
              momentumRatio: 1,
              momentumVelocityRatio: 1,
              momentumBounce: false,
            },
            grabCursor: true,
            navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
            },
            on: {
              init() {
                skeleton.style.display = "none";
              },
            },
            breakpoints: {
              374: {
                spaceBetween: 8,
                slidesPerView: 2.55,
              },
              390: {
                spaceBetween: 8,
                slidesPerView: 2.552,
              },
              400: {
                spaceBetween: 8,
                slidesPerView: 2.556,
              },
              412: {
                spaceBetween: 8,
                slidesPerView: 2.557,
              },
              430: {
                spaceBetween: 8,
                slidesPerView: 2.563,
              },
              440: {
                spaceBetween: 8,
                slidesPerView: 2.565,
              },
              480: {
                spaceBetween: 8,
                slidesPerView: 2.575,
              },
              600: {
                spaceBetween: 8,
                slidesPerView: 3.893,
              },
              768: {
                spaceBetween: 8,
                slidesPerView: 3.9174,
              },
              800: {
                spaceBetween: 8,
                slidesPerView: 3.92,
              },
              900: {
                spaceBetween: 16,
                slidesPerView: 6.11,
              },
              1024: {
                spaceBetween: 16,
                slidesPerView: 6.093,
              },
              1200: {
                spaceBetween: 16,
                slidesPerView: 6.08,
              },
              1280: {
                spaceBetween: 16,
                slidesPerView: 5.925,
              },
            },
          });
        });
    }

    // Tabs click
    tabs.forEach((tab, i) => {
      tab.onclick = () => setActive(i);
    });

    setActive(0);
  });
});
