"use strict";
const preLoader = function () {
    let e = document.getElementById("preloader");
    window.onload = () => {
        e.classList.add("addloaded")
    }
};
var getSiblings = function (e) {
    const t = [];
    let i = e.parentNode.firstChild;
    for (; i;) 1 === i.nodeType && i !== e && t.push(i), i = i.nextSibling;
    return t
},
    slideUp = (e, t) => {
        const i = t || 500;
        e.style.transitionProperty = "height, margin, padding", e.style.transitionDuration = i + "ms", e.style.boxSizing = "border-box", e.style.height = e.offsetHeight + "px", e.offsetHeight, e.style.overflow = "hidden", e.style.height = 0, window.setTimeout((() => {
            e.style.display = "none", e.style.removeProperty("height"), e.style.removeProperty("overflow"), e.style.removeProperty("transition-duration"), e.style.removeProperty("transition-property")
        }), i)
    },
    slideDown = (e, t) => {
        const i = t || 500;
        e.style.removeProperty("display");
        let s = window.getComputedStyle(e).display;
        "none" === s && (s = "block"), e.style.display = s;
        const n = e.offsetHeight;
        e.style.overflow = "hidden", e.style.height = 0, e.offsetHeight, e.style.boxSizing = "border-box", e.style.transitionProperty = "height, margin, padding", e.style.transitionDuration = i + "ms", e.style.height = n + "px", window.setTimeout((() => {
            e.style.removeProperty("height"), e.style.removeProperty("overflow"), e.style.removeProperty("transition-duration"), e.style.removeProperty("transition-property")
        }), i)
    };

function TopOffset(e) {
    let t = e.getBoundingClientRect(),
        i = window.pageYOffset || document.documentElement.scrollTop;
    return {
        top: t.top + i
    }
}
const headerStickyWrapper = document.querySelector("header"),
    headerStickyTarget = document.querySelector(".header__sticky");
headerStickyTarget && window.addEventListener("scroll", (function () {
    let e = TopOffset(headerStickyWrapper).top;
    window.scrollY > e ? headerStickyTarget.classList.add("sticky") : headerStickyTarget.classList.remove("sticky")
}));
const scrollTop = document.getElementById("scroll__top");
scrollTop.addEventListener("click", (function () {
    window.scroll({
        top: 0,
        left: 0,
        behavior: "smooth"
    })
})), window.addEventListener("scroll", (function () {
    window.scrollY > 300 ? scrollTop.classList.add("active") : scrollTop.classList.remove("active")
}));
var swiper = new Swiper(".hero__slider--activation", {
    slidesPerView: 1,
    loop: !0,
    clickable: !0,
    effect: "fade",
    speed: 500,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    }
}),
    swiper2 = (swiper = new Swiper(".product__swiper--column3", {
        slidesPerView: 3,
        clickable: !0,
        loop: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            280: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        grid: {
            fill: "row",
            rows: 2
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".product__swiper--column4", {
        slidesPerView: 4,
        clickable: !0,
        loop: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".product__swiper--column5", {
        slidesPerView: 5,
        clickable: !0,
        loop: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 5
            },
            992: {
                slidesPerView: 4
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            280: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".product__list--column3", {
        slidesPerView: 3,
        clickable: !0,
        loop: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            450: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            280: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: !0
        }
    }), swiper = new Swiper(".testimonial__swiper--activation", {
        slidesPerView: 2,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            768: {
                spaceBetween: 30,
                slidesPerView: 2
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: !0
        }
    }), swiper = new Swiper(".testimonial__swiper--column3", {
        slidesPerView: 3,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                spaceBetween: 30,
                slidesPerView: 3
            },
            992: {
                spaceBetween: 30,
                slidesPerView: 2
            },
            768: {
                spaceBetween: 30,
                slidesPerView: 2
            },
            576: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: !0
        }
    }), swiper = new Swiper(".testimonial__swiper--column4", {
        slidesPerView: 4,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                spaceBetween: 30,
                slidesPerView: 4
            },
            992: {
                spaceBetween: 30,
                slidesPerView: 3
            },
            768: {
                spaceBetween: 30,
                slidesPerView: 2
            },
            480: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            300: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: !0
        }
    }), swiper = new Swiper(".blog__swiper--activation", {
        slidesPerView: 4,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1500: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".shop__swiper--activation", {
        slidesPerView: 4,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1500: {
                slidesPerView: 5
            },
            992: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".color__swiper--activation", {
        slidesPerView: 4,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1500: {
                slidesPerView: 6
            },
            992: {
                slidesPerView: 6
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".pattern__swiper--activation", {
        slidesPerView: 4,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1500: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 4
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".material__swiper--activation", {
        slidesPerView: 4,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1500: {
                slidesPerView: 5
            },
            992: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".popular__swiper--activation", {
        slidesPerView: 4,
        clickable: !0,
        spaceBetween: 20,
        breakpoints: {
            1331: {
                slidesPerView: 7
            },
            1330: {
                slidesPerView: 6
            },
            992: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".blog__swiper--column3", {
        slidesPerView: 3,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".instagram__swiper--activation", {
        slidesPerView: 7,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 7
            },
            992: {
                slidesPerView: 6
            },
            768: {
                slidesPerView: 5,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 2
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".instagram__swiper--column5", {
        slidesPerView: 5,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        breakpoints: {
            1200: {
                slidesPerView: 5
            },
            992: {
                slidesPerView: 4
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            0: {
                slidesPerView: 2
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), swiper = new Swiper(".quickview__swiper--activation", {
        slidesPerView: 1,
        loop: !0,
        clickable: !0,
        spaceBetween: 30,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: !0
        }
    }), swiper = new Swiper(".product__media--nav_1", {
        loop: !1,
        spaceBetween: 10,
        slidesPerView: 5,
        freeMode: !0,
        watchSlidesProgress: !0,
        breakpoints: {
            768: {
                slidesPerView: 5
            },
            480: {
                slidesPerView: 4
            },
            320: {
                slidesPerView: 3
            },
            200: {
                slidesPerView: 2
            },
            0: {
                slidesPerView: 1
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    }), new Swiper(".product__media--preview_1", {
        loop: !0,
        spaceBetween: 10,
        thumbs: {
            swiper: swiper
        }
    }));
// const city_name = document.getElementById("citynameone").value;
// console.log("city_name", city_name);
const tab = function () {
    document.querySelectorAll('[data-toggle="tab"]').forEach((function (e) {
        e.addEventListener("click", (function () {
            const e = this.getAttribute("data-target"),
                t = document.querySelector(e);
            this.parentElement.querySelectorAll('[data-toggle="tab"]').forEach((function (e) {
                e.classList.remove("active")
            })), this.classList.add("active"), t.classList.add("active"), setTimeout((function () {
                t.classList.add("show")
            }), 150), getSiblings(t).forEach((function (e) {
                e.classList.remove("show"), setTimeout((function () {
                    e.classList.remove("active")
                }), 150)
            }))
        }))
    }))
};
document.querySelectorAll('[data-toggle="tab"]').forEach((function (e) {
    e.addEventListener("click", (function () {
        const e = this.getAttribute("data-target"),
            t = document.querySelector(e);
        this.parentElement.querySelectorAll('[data-toggle="tab"]').forEach((function (e) {
            e.classList.remove("active")
        })), this.classList.add("active"), t.classList.add("active"), setTimeout((function () {
            t.classList.add("show")
        }), 150), getSiblings(t).forEach((function (e) {
            e.classList.remove("show"), setTimeout((function () {
                e.classList.remove("active")
            }), 150)
        }))
    }))
})), document.querySelectorAll("[data-countdown]").forEach((function (e) {
    const t = function (e, t) {
        return `<div class="countdown__item" ${t}"><span class="countdown__number">${e}</span><p class="countdown__text">${t}</p></div>`
    },
        i = new Date(e.getAttribute("data-countdown")).getTime(),
        s = 864e5,
        n = setInterval((function () {
            let o = (new Date).getTime(),
                r = i - o,
                c = Math.floor(r / s),
                a = Math.floor(r % s / 36e5),
                l = Math.floor(r % 36e5 / 6e4),
                d = Math.floor(r % 6e4 / 1e3);
            e.innerHTML = t(c, "days") + t(a, "hrs") + t(l, "mins") + t(d, "secs"), r < 0 && clearInterval(n)
        }), 1e3)
}));
const activeClassAction = function (e, t) {
    const i = document.querySelector(e),
        s = document.querySelector(t);
    i && s && (i.addEventListener("click", (function (e) {
        e.preventDefault(), this.classList.contains("active") ? (this.classList.remove("active"), s.classList.remove("active")) : (this.classList.add("active"), s.classList.add("active"))
    })), document.addEventListener("click", (function (n) {
        n.target.closest(e) || n.target.classList.contains(e.replace(/\./, "")) || n.target.closest(t) || n.target.classList.contains(t.replace(/\./, "")) || (i.classList.remove("active"), s.classList.remove("active"))
    })))
};

function offcanvsSidebar(e, t, i) {
    let s = document.querySelectorAll(e),
        n = document.querySelector(t),
        o = document.querySelector(i),
        r = i.replace(".", "");

    function c(t) {
        let s = t.target;
        s.closest(i) || s.closest(e) || (o.classList.remove("active"), document.querySelector("body").classList.remove(`${r}_active`))
    }
    s && o && s.forEach((function (e) {
        e.addEventListener("click", (function () {
            o.classList.add("active"), document.querySelector("body").classList.add(`${r}_active`), document.body.addEventListener("click", c.bind(this))
        }))
    })), n && o && n.addEventListener("click", (function () {
        o.classList.remove("active"), document.querySelector("body").classList.remove(`${r}_active`), document.body.removeEventListener("click", c.bind(this))
    }))
}
activeClassAction(".account__currency--link", ".dropdown__currency"), activeClassAction(".language__switcher", ".dropdown__language"), activeClassAction(".offcanvas__language--switcher", ".offcanvas__dropdown--language"), activeClassAction(".offcanvas__account--currency__menu", ".offcanvas__account--currency__submenu"), offcanvsSidebar(".minicart__open--btn", ".minicart__close--btn", ".offCanvas__minicart"), offcanvsSidebar(".search__open--btn", ".predictive__search--close__btn", ".predictive__search--box"), offcanvsSidebar(".widget__filter--btn", ".offcanvas__filter--close", ".offcanvas__filter--sidebar");
const offcanvasHeader = function () {
    const e = document.querySelector(".offcanvas__header--menu__open--btn"),
        t = document.querySelector(".offcanvas__close--btn"),
        i = document.querySelector(".offcanvas-header"),
        s = document.querySelector(".offcanvas__menu"),
        n = document.querySelector("body");
    s && s.querySelectorAll(".offcanvas__sub_menu").forEach((function (e) {
        const t = document.createElement("button");
        t.classList.add("offcanvas__sub_menu_toggle"), e.parentNode.appendChild(t)
    })), e && e.addEventListener("click", (function (e) {
        e.preventDefault(), i.classList.add("open"), n.classList.add("mobile_menu_open")
    })), t && t.addEventListener("click", (function (e) {
        e.preventDefault(), i.classList.remove("open"), n.classList.remove("mobile_menu_open")
    })), s && s.querySelectorAll(".offcanvas__sub_menu_toggle").forEach((function (e) {
        e.addEventListener("click", (function (e) {
            e.preventDefault();
            const t = this.parentElement;
            t.classList.contains("active") ? (this.classList.remove("active"), t.classList.remove("active"), t.querySelectorAll(".offcanvas__sub_menu").forEach((function (e) {
                e.parentElement.classList.remove("active"), e.nextElementSibling.classList.remove("active"), slideUp(e)
            }))) : (this.classList.add("active"), t.classList.add("active"), slideDown(this.previousElementSibling), getSiblings(t).forEach((function (e) {
                e.classList.remove("active"), e.querySelectorAll(".offcanvas__sub_menu").forEach((function (e) {
                    e.parentElement.classList.remove("active"), e.nextElementSibling.classList.remove("active"), slideUp(e)
                }))
            })))
        }))
    })), document.addEventListener("click", (function (e) {
        e.target.closest(".offcanvas__header--menu__open--btn") || e.target.classList.contains(".offcanvas__header--menu__open--btn".replace(/\./, "")) || e.target.closest(".offcanvas-header") || e.target.classList.contains(".offcanvas-header".replace(/\./, "")) || (i?.classList.remove("open"), n.classList.remove("mobile_menu_open"))
    })), window.addEventListener("resize", (function () {
        window.outerWidth >= 992 && (i.classList.remove("open"), n.classList.remove("mobile_menu_open"))
    }))
};
offcanvasHeader();
const quantityWrapper = document.querySelectorAll(".quantity__box");
quantityWrapper && quantityWrapper.forEach((function (e) {
    let t = e.querySelector(".quantity__number"),
        i = e.querySelector(".increase"),
        s = e.querySelector(".decrease");
    i.addEventListener("click", (function () {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e++, t.value = e
    })), s.addEventListener("click", (function () {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e < 2 && (e = 2), e--, t.value = e
    }))
}));
const quantityWrappers = document.querySelectorAll(".quantity__boxs");
quantityWrappers && quantityWrappers.forEach((function (e) {
    let t = e.querySelector(".quantity__number"),
        i = e.querySelector(".increase"),
        s = e.querySelector(".decrease");
    i.addEventListener("click", (function () {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e++, t.value = e
    })), s.addEventListener("click", (function () {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e < 1 && (e = 1), e--, t.value = e
    }))
}));
const openEls = document.querySelectorAll("[data-open]"),
    closeEls = document.querySelectorAll("[data-close]"),
    isVisible = "is-visible";
for (const e of openEls) e.addEventListener("click", (function () {
    const e = this.dataset.open;
    document.getElementById(e).classList.add(isVisible)
}));
for (const e of closeEls) e.addEventListener("click", (function () {
    this.parentElement.parentElement.parentElement.classList.remove(isVisible)
}));

function customAccordion(e, t, i) {
    document.querySelectorAll(t).forEach((function (t) {
        t.addEventListener("click", (function () {
            let t = this.closest(e),
                s = t.querySelector(i);
            t.classList.contains("active") ? (t.classList.remove("active"), slideUp(s)) : (t.classList.add("active"), slideDown(s), getSiblings(t).forEach((function (e) {
                let t = e.querySelector(i);
                e.classList.remove("active"), slideUp(t)
            })))
        }))
    }))
}
document.addEventListener("click", (e => {
    e.target == document.querySelector(".modal.is-visible") && document.querySelector(".modal.is-visible").classList.remove(isVisible)
})), document.addEventListener("keyup", (e => {
    "Escape" == e.key && document.querySelector(".modal.is-visible") && document.querySelector(".modal.is-visible").classList.remove(isVisible)
})), customAccordion(".accordion__items", ".accordion__items--button", ".accordion__items--body"), customAccordion(".widget__categories--menu__list", ".widget__categories--menu__label", ".widget__categories--sub__menu");
let accordion = !0;
const footerWidgetAccordion = function () {
    accordion = !1, document.querySelectorAll(".footer__widget--button").forEach((function (e) {
        e.addEventListener("click", (function () {
            const e = this.closest(".footer__widget"),
                t = e.querySelector(".footer__widget--inner");
            e.classList.contains("active") ? (e.classList.remove("active"), slideUp(t)) : (e.classList.add("active"), slideDown(t), getSiblings(e.parentElement).forEach((function (e) {
                const t = e.querySelector(".footer__widget"),
                    i = e.querySelector(".footer__widget--inner");
                t.classList.remove("active"), slideUp(i)
            })))
        }))
    }))
};
window.addEventListener("load", (function () {
    accordion && footerWidgetAccordion()
})), window.addEventListener("resize", (function () {
    document.querySelectorAll(".footer__widget").forEach((function (e) {
        window.outerWidth >= 768 && (e.classList.remove("active"), e.querySelector(".footer__widget--inner").style.display = "")
    })), accordion && footerWidgetAccordion()
}));
const customLightboxHTML = '<div id="glightbox-body" class="glightbox-container">\n    <div class="gloader visible"></div>\n    <div class="goverlay"></div>\n    <div class="gcontainer">\n    <div id="glightbox-slider" class="gslider"></div>\n    <button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>\n    <button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>\n    <button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>\n    </div>\n    </div>',
    lightbox = GLightbox({
        touchNavigation: !0,
        lightboxHTML: customLightboxHTML,
        loop: !0
    }),
    wrapper = document.getElementById("funfactId");
if (wrapper) {
    const e = wrapper.querySelectorAll(".js-counter"),
        t = 1e3;
    let i = !1;
    document.addEventListener("scroll", (function () {
        const s = wrapper.offsetTop - window.innerHeight;
        !i && window.scrollY > s && (e.forEach((e => {
            const i = e.dataset.count,
                s = i / t;
            let n = 0;
            const o = setInterval((function () {
                n >= i && clearInterval(o), e.textContent = Math.round(n), n += s
            }), 1)
        })), i = !0)
    }))
}
const categoryMobileMenu = function () {
    const e = document.querySelector(".category__mobile--menu");
    e && e.querySelectorAll(".category__sub--menu").forEach((function (e) {
        let t = document.createElement("button");
        t.classList.add("category__sub--menu_toggle"), e.parentNode.appendChild(t)
    })), e && e.querySelectorAll(".category__sub--menu_toggle").forEach((function (e) {
        e.addEventListener("click", (function (e) {
            e.preventDefault();
            let t = this.parentElement;
            t.classList.contains("active") ? (this.classList.remove("active"), t.classList.remove("active"), t.querySelectorAll(".category__sub--menu").forEach((function (e) {
                e.parentElement.classList.remove("active"), e.nextElementSibling.classList.remove("active"), slideUp(e)
            }))) : (this.classList.add("active"), t.classList.add("active"), slideDown(this.previousElementSibling), getSiblings(t).forEach((function (e) {
                e.classList.remove("active"), e.querySelectorAll(".category__sub--menu").forEach((function (e) {
                    e.parentElement.classList.remove("active"), e.nextElementSibling.classList.remove("active"), slideUp(e)
                }))
            })))
        }))
    }))
};
categoryMobileMenu();
// let newsletterWrapper = document.querySelector(".newsletter__popup"),
//     newsletterCloseButton = document.querySelector(".newsletter__popup--close__btn"),
//     dontShowPopup = document.querySelector("#newsletter__dont--show"),
//     popuDontShowMode = city_name;
// const newsletterPopup = function () {
//     let e = document.querySelector(".newsletter__popup"),
//         t = (document.querySelector(".newsletter__popup--close__btn"), document.querySelector("#newsletter__dont--show"), city_name);
//     document.getElementById("userName_check").value;
//     e && "" == t && selectCity()
// };

// function removeCitywithlog() {
//     window.localStorage.removeItem("city"), popuDontShowMode = city_name
// }

function selectCity() {
    setTimeout((function () {
        document.body.classList.add("overlay__active"), document.querySelector(".newsletter__popup").classList.add("newsletter__show"), document.addEventListener("click", (function (e) {
            e.target.closest(".newsletter__popup--inner")
        })), document.querySelector(".newsletter__popup--close__btn").addEventListener("click", (function () {
            document.body.classList.remove("overlay__active"), document.querySelector(".newsletter__popup").classList.remove("newsletter__show")
        }))
    }), 10)
}
// newsletterPopup();