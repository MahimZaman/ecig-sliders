$ = jQuery;

$(document).ready(function () {
  document.querySelectorAll(".ecig-banner-wrap").forEach((wrapper) => {
    if (wrapper.dataset.init) return;
    wrapper.dataset.init = true;

    const swiperEl = wrapper.querySelector(".ecig-banner-swiper");

    new Swiper(swiperEl, {
      effect: "coverflow",
      grabCursor: true,
      loop: true,
      centeredSlides: true,
      speed: 900,
      slidesPerView: 1.57,
      coverflowEffect: {
        rotate: 0,
        stretch: 26,
        depth: 125,
        modifier: 5.4,
        slideShadows: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: wrapper.querySelector(".ecig-banner-pagination"),
        clickable: true,
      },
      breakpoints: {
        390: {
          slidesPerView: 1.57,
          coverflowEffect: {
            rotate: 0,
            stretch: 24,
            depth: 125,
            modifier: 5.35,
            slideShadows: false,
          },
        },
        412: {
          slidesPerView: 1.57,
          coverflowEffect: {
            rotate: 0,
            stretch: 22,
            depth: 125,
            modifier: 5.35,
            slideShadows: false,
          },
        },
        430: {
          slidesPerView: 1.57,
          coverflowEffect: {
            rotate: 0,
            stretch: 20,
            depth: 125,
            modifier: 5.35,
            slideShadows: false,
          },
        },
        440: {
          slidesPerView: 1.57,
          coverflowEffect: {
            rotate: 0,
            stretch: 19,
            depth: 125,
            modifier: 5.35,
            slideShadows: false,
          },
        },
        480: {
          slidesPerView: 1.57,
          coverflowEffect: {
            rotate: 0,
            stretch: 19,
            depth: 125,
            modifier: 4.8,
            slideShadows: false,
          },
        },
        600: {
          slidesPerView: 1.8,
          coverflowEffect: {
            rotate: 0,
            stretch: 100,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        768: {
          slidesPerView: 1.6,
          coverflowEffect: {
            rotate: 0,
            stretch: 80,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        900: {
          slidesPerView: 1.14,
          coverflowEffect: {
            rotate: 0,
            stretch: 80,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        1024: {
          slidesPerView: 1.3,
          coverflowEffect: {
            rotate: 0,
            stretch: 80,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        1100: {
          slidesPerView: 1.4,
          coverflowEffect: {
            rotate: 0,
            stretch: 80,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        1200: {
          slidesPerView: 1.6,
          coverflowEffect: {
            rotate: 0,
            stretch: 80,
            depth: 150,
            modifier: 2.4,
            slideShadows: false,
          },
        },
        1280: {
          slidesPerView: 2.3,
          coverflowEffect: {
            rotate: 0,
            stretch: 100,
            depth: 150,
            modifier: 2.6,
            slideShadows: false,
          },
        },
        1320: {
          slidesPerView: 2.31,
          coverflowEffect: {
            rotate: 0,
            stretch: 100,
            depth: 150,
            modifier: 2.6,
            slideShadows: false,
          },
        },
      },
    });
  });
});
