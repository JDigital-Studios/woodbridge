import "./main.css";

import AOS from "aos";
import { tns } from "./../node_modules/tiny-slider/src/tiny-slider";

const detectMobileJS = () => {
  const isMobile = {
    hasTouch: function () {
      return "ontouchstart" in document.documentElement;
    },
    Android: function () {
      return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
      return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
      return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
      return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
      return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
      return (
        isMobile.Android() ||
        isMobile.BlackBerry() ||
        isMobile.iOS() ||
        isMobile.Opera() ||
        isMobile.Windows()
      );
    },
    ismobi: function () {
      return navigator.userAgent.match(/Mobi/i);
    },
  };

  if (!isMobile.hasTouch()) {
    document.querySelector("body").classList.add("no-touch");
  } else {
    document.querySelector("body").classList.add("touch");
  }
};

const headerJS = () => {
  const btnMenu = document.querySelector(".btn-menu");
  const mainNavigation = document.querySelector(".main-header-navigation");

  if (btnMenu) {
    btnMenu.addEventListener("click", () => {
      // console.log('Clicked!');

      btnMenu.classList.toggle("active");
      mainNavigation.classList.toggle("active");
    });
  }
};

const stickyHeaderJS = () => {
  const mainHeader = document.querySelector(".main-header");
  let lastScrollPosition = 0;

  window.addEventListener("scroll", () => {
    const currentScrollPosition = window.scrollY;
    // const documentHeight = document.documentElement.scrollHeight;
    // const windowHeight = window.innerHeight;

    if (currentScrollPosition > 0) {
      mainHeader.classList.add("active");
    } else {
      mainHeader.classList.remove("active");
    }

    if (currentScrollPosition > 0) {
      if (currentScrollPosition > lastScrollPosition) {
        mainHeader.classList.remove("active-again");
      } else if (currentScrollPosition < lastScrollPosition) {
        mainHeader.classList.add("active-again");
      }
    }

    lastScrollPosition = currentScrollPosition;
  });
};

const testimonialSliderJS = () => {
  const testimonialSliders = document.querySelectorAll(".testimonials-slider");

  if (!testimonialSliders.length) return;

  testimonialSliders.forEach((slider) => {
    tns({
      container: slider,
      mode: "carousel",
      items: 1,
      fixedWidth: 300,
      gutter: 24,
      mouseDrag: true,
      touch: true,
      preventScrollOnTouch: "auto",
      autoplay: true,
      autoplayTimeout: 4000,
      loop: true,
      autoplayButtonOutput: false,
      nav: false,
      controls: true,
      responsive: {
        0: {
          fixedWidth: 300,
          gutter: 0,
        },
        768: {
          fixedWidth: 300,
          gutter: 16,
        },
        1024: {
          fixedWidth: 300,
          gutter: 24,
        },
      },
    });
  });
};

const productsSliderJS = () => {
  const productSlider = document.querySelectorAll(".products-slider");

  if (productSlider) {
    productSlider.forEach((slider) => {
      const tnsSlider = tns({
        container: slider,
        mode: "carousel",
        autoplay: true,
        autoplayTimeout: 4000,
        autoWidth: false,
        mouseDrag: false,
        loop: true,
        nav: false,
        gutter: 0,
        controls: true,
        autoplayButtonOutput: false,
        responsive: {
          0: { items: 2 },
          768: { items: 3 },
          1024: { items: 4 },
        },
      });
    });
  }
};

const varietalSliderJS = () => {
  const sliders = document.querySelectorAll(".hero-varietal-slider");

  if (!sliders.length) return;

  sliders.forEach((slider, index) => {
    const thumb = document.querySelectorAll(".hero-varietal-thumbnail-slider")[
      index
    ];
    const thumbItems = thumb.querySelectorAll(".slideshow").length;

    // Skip slider if only 1 item
    if (thumbItems <= 1) {
      thumb.classList.add("no-hero-varietal-thumbnail-slider");
      return;
    }

    // Default to 1.5L slide if present
    const defaultSlide = thumb.querySelector(".size-1-5L");
    const startIndex = defaultSlide
      ? [...thumb.querySelectorAll(".slideshow")].indexOf(defaultSlide)
      : 0;

    // Thumbnail slider
    const thumbnailSlider = tns({
      container: thumb,
      autoWidth: true,
      gutter: 0,
      controls: false,
      nav: false,
      mouseDrag: true,
      loop: false,
      startIndex: startIndex,
    });

    // Main slider
    const mainSlider = tns({
      container: slider,
      mode: "gallery",
      items: 1,
      controls: false,
      nav: true,
      navContainer: thumb,
      navAsThumbnails: true,
      autoplay: true,
      autoplayTimeout: 2000,
      autoplayButtonOutput: false,
      autoplayHoverPause: true,
      autoplayResetOnVisibility: false,
      mouseDrag: false,
      loop: true,
      startIndex: startIndex,
    });

    mainSlider.events.on("transitionEnd", () => {
      mainSlider.play();
    });
  });
};

// TWG Legal popup content is now hydrated by the TWG Legal plugin
// (data-twg-legal-popup opt-in) which performs {SITE} / {EMAIL} token
// replacement. The custom loader has been removed; the popup open
// handler below only toggles visibility and lets the plugin's
// MutationObserver + fetch handle the rest.

const popupsJS = () => {
  const openPopupButtons = document.querySelectorAll(".open-popup");
  const closePopupButtons = document.querySelectorAll(".close-popup");
  const popupOverlay = document.querySelectorAll(".content-popup-overlay");
  const noScroll = document.querySelector("html");

  openPopupButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const popupId = this.getAttribute("href").replace("#", "");
      const popup = document.getElementById(popupId);

      if (popup) {
        popup.classList.add("active");
        noScroll.classList.add("no-scroll");
      }
    });
  });

  closePopupButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const popupBox = this.closest(".content-popup");

      if (popupBox) {
        popupBox.classList.remove("active");
        noScroll.classList.remove("no-scroll");
      }
    });
  });
  popupOverlay.forEach(function (overlay) {
    overlay.addEventListener("click", function () {
      const popupBox = this.closest(".content-popup");

      if (popupBox) {
        popupBox.classList.remove("active");
        noScroll.classList.remove("no-scroll");
      }
    });
  });
};

const wineFilterJS = () => {
  const filterLinks = document.querySelectorAll(".filter-menu li a");
  const items = document.querySelectorAll("[data-category]");

  if (!filterLinks.length) return;

  const applyFilter = (filter) => {
    filterLinks.forEach((link) => {
      link.classList.remove("active");

      if (link.getAttribute("href") === `#${filter}`) {
        link.classList.add("active");
      }
    });

    items.forEach((item) => {
      const category = item.dataset.category;

      if (filter === "all" || category === filter) {
        item.classList.remove("hidden");
      } else {
        item.classList.add("hidden");
      }
    });

    setTimeout(() => {
      AOS.refresh();
    }, 100);
  };

  filterLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      window.location.hash = link.getAttribute("href").substring(1);
    });
  });

  const applyHashFilter = () => {
    const hash = window.location.hash.replace("#", "");
    applyFilter(hash || "all");
  };

  window.addEventListener("hashchange", applyHashFilter);
  applyHashFilter();
};

const parallaxScrollJS = () => {
  if (!window.matchMedia("(min-width: 1024px)").matches) return;

  const heroPairs = [];

  document.querySelectorAll(".hero-parallax").forEach((section) => {
    const image = section.querySelector(".hero-parallax-image");
    if (image) {
      const wh = window.innerHeight;
      const sh = section.offsetHeight;
      const overhangPx = Math.max(40, (wh - sh) / 2);
      const overhangVh = (overhangPx / wh) * 100;
      image.style.top = `-${overhangVh}vh`;
      image.style.bottom = `-${overhangVh}vh`;
      image.style.visibility = "hidden";
      heroPairs.push({ section, image, drift: overhangVh * 2 });
    }
  });

  if (!heroPairs.length) return;

  let ticking = false;

  const update = () => {
    const wh = window.innerHeight;

    heroPairs.forEach(({ section, image, drift }) => {
      const rect = section.getBoundingClientRect();
      const visible = rect.bottom > 0 && rect.top < wh;

      image.style.visibility = visible ? "visible" : "hidden";
      if (!visible) return;

      const progress = (wh - rect.top) / (wh + section.offsetHeight);
      const offset = drift / 2 - progress * drift;
      image.style.transform = `translateY(${offset}vh)`;
    });

    ticking = false;
  };

  window.addEventListener(
    "scroll",
    () => {
      if (!ticking) {
        requestAnimationFrame(update);
        ticking = true;
      }
    },
    { passive: true },
  );

  update();
};

detectMobileJS();
headerJS();
stickyHeaderJS();
parallaxScrollJS();
testimonialSliderJS();
productsSliderJS();
popupsJS();
varietalSliderJS();
wineFilterJS();

// Tabs on "Our Story" page
if (jQuery(".tabs-slider-section").length > 0) {
  jQuery(".tab-thumbnail-slider .slideshow")
    .removeClass("active")
    .eq(0)
    .addClass("active");

  jQuery(".tab-thumbnail-slider .slideshow").on("click", function () {
    const index = jQuery(this).index();

    const scroll = jQuery(".tab-main-slider-scroll");
    const slideWidth = jQuery(".tab-main-slider .slideshow").outerWidth(true);

    const scrollX = index * slideWidth;

    scroll.mCustomScrollbar("scrollTo", scrollX, {
      scrollInertia: 400,
    });
  });

  function updateNavState(index, totalSlides) {
    const prevBtn = jQuery('[data-tab="prev"]');
    const nextBtn = jQuery('[data-tab="next"]');

    prevBtn.toggleClass("is-disabled", index <= 0);
    nextBtn.toggleClass("is-disabled", index >= totalSlides - 1);
  }

  jQuery('[data-tab="prev"]').on("click", function () {
    const slideWidth = getSlideWidth();
    const totalSlides = jQuery(".tab-main-slider .slideshow").length;

    const left = Math.abs(jQuery(".tab-main-slider-scroll")[0].mcs.left);
    let index = Math.round(left / slideWidth);

    index = Math.max(0, index - 1);

    jQuery(".tab-main-slider-scroll").mCustomScrollbar(
      "scrollTo",
      index * slideWidth,
      {
        scrollInertia: 400,
      },
    );

    updateNavState(index, totalSlides);
  });

  jQuery('[data-tab="next"]').on("click", function () {
    const slideWidth = getSlideWidth();
    const totalSlides = jQuery(".tab-main-slider .slideshow").length;

    const left = Math.abs(jQuery(".tab-main-slider-scroll")[0].mcs.left);
    let index = Math.round(left / slideWidth);

    index = Math.min(totalSlides - 1, index + 1);

    jQuery(".tab-main-slider-scroll").mCustomScrollbar(
      "scrollTo",
      index * slideWidth,
      {
        scrollInertia: 400,
      },
    );

    updateNavState(index, totalSlides);
  });

  const totalSlides = jQuery(".tab-main-slider .slideshow").length;

  function getSlideWidth() {
    return jQuery(".tab-main-slider .slideshow").outerWidth(true);
  }

  jQuery(".tab-main-slider-scroll").mCustomScrollbar({
    axis: "x",
    scrollInertia: 250,
    advanced: {
      autoExpandHorizontalScroll: true,
    },
    callbacks: {
      onScroll: function () {
        const slideWidth = getSlideWidth();
        const left = Math.abs(this.mcs.left);

        const index = Math.round(left / slideWidth);
        const clampedIndex = Math.max(0, Math.min(index, totalSlides - 1));

        const snapX = clampedIndex * slideWidth;

        if (Math.abs(left - snapX) > 5) {
          jQuery(this).mCustomScrollbar("scrollTo", snapX, {
            scrollInertia: 450,
            timeout: 0,
          });
        }

        jQuery(".tab-thumbnail-slider .slideshow")
          .removeClass("active")
          .eq(clampedIndex)
          .addClass("active");
        updateNavState(clampedIndex, totalSlides);
      },
    },
  });
}

document.addEventListener("DOMContentLoaded", () => {
  AOS.init();

  const popup = document.querySelector(".age-popup");
  const welcomePopup = document.querySelector(".welcome-popup");
  const welcomePopupCloseBtn = document.querySelector(".close-welcome-popup");
  let welcomePopupTriggered = false;
  let scrollTimer = null;

  const termsPopup = document.getElementById("terms-popup");
  const privacyPopup = document.getElementById("privacy-popup");

  if (popup) {
    const yesButton = document.querySelector(".age-popup .age-button-yes");
    const noButton = document.querySelector(".age-popup .age-button-no");
    const termsCheckbox = document.querySelector(
      ".age-popup .custom-checkbox input",
    );

    if (getCookie("WoodbridgeCookieAge") !== "true") {
      popup.classList.add("active");
    } else {
      popup.classList.remove("active");

      if (termsPopup) termsPopup.remove();
      if (privacyPopup) privacyPopup.remove();

      if (window.location.hash) {
        const anchor = document.querySelector(window.location.hash);
        if (anchor) {
          anchor.scrollIntoView({ behavior: "instant" });
        }
      }

      initWelcomePopupTrigger();
    }

    yesButton.addEventListener("click", function (event) {
      event.preventDefault();

      if (!termsCheckbox.checked) {
        alert("You must agree to the terms of service and any Privacy Policy.");
        return;
      }

      setCookie("WoodbridgeCookieAge", "true", 30);

      popup.classList.remove("active");

      if (termsPopup) termsPopup.remove();
      if (privacyPopup) privacyPopup.remove();

      initWelcomePopupTrigger();
    });

    noButton.addEventListener("click", function (event) {
      event.preventDefault();

      alert("You must be at least 21 years old to view this site.");
    });
  }

  function initWelcomePopupTrigger() {
    if (getCookie("WoodbridgeCookieWelcome")) return;

    const handleScroll = () => {
      if (welcomePopupTriggered) return;

      welcomePopupTriggered = true;

      scrollTimer = setTimeout(() => {
        welcomePopup.classList.remove("hidden");

        requestAnimationFrame(() => {
          welcomePopup.classList.add("active");
        });
      }, 3000);

      window.removeEventListener("scroll", handleScroll);
    };

    window.addEventListener("scroll", handleScroll, { passive: true });
  }

  if (welcomePopupCloseBtn) {
    welcomePopupCloseBtn.addEventListener("click", () => {
      welcomePopup.classList.remove("active");

      setTimeout(() => {
        welcomePopup.classList.add("hidden");
      }, 300);

      setCookie("WoodbridgeCookieWelcome", "true", 30);
    });
  }

  function setCookie(name, value, days) {
    let expires = "";

    if (days) {
      let date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(";");

    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];

      while (c.charAt(0) === " ") {
        c = c.substring(1, c.length);
      }

      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length, c.length);
      }
    }

    return null;
  }
});
