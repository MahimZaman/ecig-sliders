$ = jQuery;

$(document).ready(function () {
  document.querySelectorAll(".ecig-swiper-wrapper").forEach((wrapper) => {
    if (wrapper.dataset.init) return;
    wrapper.dataset.init = true;

    const swiperEl = wrapper.querySelector(".ecig-swiper");
    const skeleton = wrapper.querySelector(".ecig-skeleton");
    const prev = wrapper.querySelector(".ecig-prev");
    const next = wrapper.querySelector(".ecig-next");

    const swiper = new Swiper(swiperEl, {
      slidesPerView: 2.296,
      spaceBetween: 8,
      speed: 800,
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
          if (skeleton) skeleton.style.display = "none";
          swiperEl.style.display = "block";
          toggleArrows(this);
        },
        slideChange() {
          toggleArrows(this);
        },
        reachEnd() {
          toggleArrows(this);
        },
        reachBeginning() {
          toggleArrows(this);
        },
      },
      breakpoints: {
        374: {
          spaceBetween: 8,
          slidesPerView: 2.3,
        },
        390: {
          spaceBetween: 8,
          slidesPerView: 2.304,
        },
        400: {
          spaceBetween: 8,
          slidesPerView: 2.305,
        },
        412: {
          spaceBetween: 8,
          slidesPerView: 2.308,
        },
        430: {
          spaceBetween: 8,
          slidesPerView: 2.312,
        },
        440: {
          spaceBetween: 8,
          slidesPerView: 2.314,
        },
        480: {
          spaceBetween: 8,
          slidesPerView: 2.321,
        },
        600: {
          spaceBetween: 8,
          slidesPerView: 4.11,
        },
        768: {
          spaceBetween: 8,
          slidesPerView: 4.085,
        },
        800: {
          spaceBetween: 8,
          slidesPerView: 4.081,
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

    function toggleArrows(swiper) {
      if (prev) prev.style.display = swiper.isBeginning ? "none" : "block";
      if (next) next.style.display = swiper.isEnd ? "none" : "block";
    }
  });
});
