/**
 * Template Name: OnePage
 * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
 * Updated: Aug 07 2024 with Bootstrap v5.3.3
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */

(function () {
    "use strict";

    /**
     * Apply .scrolled class to the body as the page is scrolled down
     */
    function toggleScrolled() {
        const selectBody = document.querySelector("body");
        const selectHeader = document.querySelector("#header");
        if (
            !selectHeader.classList.contains("scroll-up-sticky") &&
            !selectHeader.classList.contains("sticky-top") &&
            !selectHeader.classList.contains("fixed-top")
        )
            return;
        window.scrollY > 100
            ? selectBody.classList.add("scrolled")
            : selectBody.classList.remove("scrolled");
    }

    document.addEventListener("scroll", toggleScrolled);
    window.addEventListener("load", toggleScrolled);

    /**
     * Mobile nav toggle
     */
    const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");

    function mobileNavToogle() {
        document.querySelector("body").classList.toggle("mobile-nav-active");
        mobileNavToggleBtn.classList.toggle("bi-list");
        mobileNavToggleBtn.classList.toggle("bi-x");
    }
    mobileNavToggleBtn.addEventListener("click", mobileNavToogle);

    /**
     * Hide mobile nav on same-page/hash links
     */
    document.querySelectorAll("#navmenu a").forEach((navmenu) => {
        navmenu.addEventListener("click", () => {
            if (document.querySelector(".mobile-nav-active")) {
                mobileNavToogle();
            }
        });
    });

    /**
     * Toggle mobile nav dropdowns
     */
    document
        .querySelectorAll(".navmenu .toggle-dropdown")
        .forEach((navmenu) => {
            navmenu.addEventListener("click", function (e) {
                e.preventDefault();
                this.parentNode.classList.toggle("active");
                this.parentNode.nextElementSibling.classList.toggle(
                    "dropdown-active"
                );
                e.stopImmediatePropagation();
            });
        });

    /**
     * Preloader
     */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    /**
     * Scroll top button
     */
    let scrollTop = document.querySelector(".scroll-top");

    function toggleScrollTop() {
        if (scrollTop) {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        }
    }
    scrollTop.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });

    window.addEventListener("load", toggleScrollTop);
    document.addEventListener("scroll", toggleScrollTop);

    /**
     * Animation on scroll function and init
     */
    function aosInit() {
        AOS.init({
            duration: 600,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }
    window.addEventListener("load", aosInit);

    /**
     * Initiate Pure Counter
     */
    new PureCounter();

    /**
     * Initiate glightbox
     */
    const glightbox = GLightbox({
        selector: ".glightbox",
    });

    /**
     * Init swiper sliders
     */
    function initSwiper() {
        document
            .querySelectorAll(".init-swiper")
            .forEach(function (swiperElement) {
                let config = JSON.parse(
                    swiperElement
                        .querySelector(".swiper-config")
                        .innerHTML.trim()
                );

                if (swiperElement.classList.contains("swiper-tab")) {
                    initSwiperWithCustomPagination(swiperElement, config);
                } else {
                    new Swiper(swiperElement, config);
                }
            });
    }

    window.addEventListener("load", initSwiper);

    /**
     * Init isotope layout and filters
     */
    document
        .querySelectorAll(".isotope-layout")
        .forEach(function (isotopeItem) {
            let layout = isotopeItem.getAttribute("data-layout") ?? "masonry";
            let filter = isotopeItem.getAttribute("data-default-filter") ?? "*";
            let sort =
                isotopeItem.getAttribute("data-sort") ?? "original-order";

            let initIsotope;
            imagesLoaded(
                isotopeItem.querySelector(".isotope-container"),
                function () {
                    initIsotope = new Isotope(
                        isotopeItem.querySelector(".isotope-container"),
                        {
                            itemSelector: ".isotope-item",
                            layoutMode: layout,
                            filter: filter,
                            sortBy: sort,
                        }
                    );
                }
            );

            isotopeItem
                .querySelectorAll(".isotope-filters li")
                .forEach(function (filters) {
                    filters.addEventListener(
                        "click",
                        function () {
                            isotopeItem
                                .querySelector(
                                    ".isotope-filters .filter-active"
                                )
                                .classList.remove("filter-active");
                            this.classList.add("filter-active");
                            initIsotope.arrange({
                                filter: this.getAttribute("data-filter"),
                            });
                            if (typeof aosInit === "function") {
                                aosInit();
                            }
                        },
                        false
                    );
                });
        });

    /**
     * Frequently Asked Questions Toggle
     */
    document
        .querySelectorAll(".faq-item h3, .faq-item .faq-toggle")
        .forEach((faqItem) => {
            faqItem.addEventListener("click", () => {
                faqItem.parentNode.classList.toggle("faq-active");
            });
        });

    /**
     * Correct scrolling position upon page load for URLs containing hash links.
     */
    window.addEventListener("load", function (e) {
        if (window.location.hash) {
            if (document.querySelector(window.location.hash)) {
                setTimeout(() => {
                    let section = document.querySelector(window.location.hash);
                    let scrollMarginTop =
                        getComputedStyle(section).scrollMarginTop;
                    window.scrollTo({
                        top: section.offsetTop - parseInt(scrollMarginTop),
                        behavior: "smooth",
                    });
                }, 100);
            }
        }
    });

    /**
     * Navmenu Scrollspy
     */
    let navmenulinks = document.querySelectorAll(".navmenu a");

    function navmenuScrollspy() {
        navmenulinks.forEach((navmenulink) => {
            if (!navmenulink.hash) return;
            let section = document.querySelector(navmenulink.hash);
            if (!section) return;
            let position = window.scrollY + 200;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                document
                    .querySelectorAll(".navmenu a.active")
                    .forEach((link) => link.classList.remove("active"));
                navmenulink.classList.add("active");
            } else {
                navmenulink.classList.remove("active");
            }
        });
    }
    window.addEventListener("load", navmenuScrollspy);
    document.addEventListener("scroll", navmenuScrollspy);
})();

window.addEventListener("load", function () {
    document.getElementById("preloader").style.display = "none";
});

// document
//     .getElementById("tambahMahasiswa")
//     .addEventListener("click", function () {
//         let container = document.getElementById("mahasiswaContainer");

//         let newInput = document.createElement("div");
//         newInput.classList.add("input-group", "mb-2");
//         newInput.innerHTML = `
//                         <input type="text" name="namaMahasiswa[]" class="form-control" placeholder="Nama Mahasiswa" required maxlength="120">
//                         <input type="text" name="nrpMahasiswa[]" class="form-control" placeholder="NRP Mahasiswa" required maxlength="9">
//                         <button type="button" class=" btn-danger removeMahasiswa rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
//                             <i class="fas fa-trash"></i>
//                         </button>
//                     `;

//         container.appendChild(newInput);
//     });

// document.addEventListener("click", function (event) {
//     if (event.target.classList.contains("removeMahasiswa")) {
//         event.target.parentElement.remove();
//     }
// });

document
    .getElementById("tambahMahasiswa")
    .addEventListener("click", function () {
        let container = document.getElementById("mahasiswaContainer");

        let newInput = document.createElement("div");
        newInput.classList.add("input-group", "mb-2");
        newInput.innerHTML = `
      <input type="text" name="namaMahasiswa[]" class="form-control" placeholder="Nama Mahasiswa" required maxlength="120">
      <input type="text" name="nrpMahasiswa[]" class="form-control" placeholder="NRP Mahasiswa" required maxlength="9">
      <button type="button" class=" btn-danger removeMahasiswa rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                    <i class="fas fa-trash"></i>
                  </button>
    `;

        container.appendChild(newInput);
    });

document
    .getElementById("mahasiswaContainer")
    .addEventListener("click", function (event) {
        // Pastikan yang diklik adalah tombol hapus
        if (event.target.closest(".removeMahasiswa")) {
            // Hapus div yang berisi input dan tombol hapus
            event.target.closest(".input-group").remove();
        }
    });

function updateFileName(input) {
    const fileName = input.files.length > 0 ? input.files[0].name : "";
    const fileNameElement = document.getElementById("fileName");
    if (fileName) {
        fileNameElement.textContent = fileName;
        fileNameElement.style.display = "inline-block";
    } else {
        fileNameElement.style.display = "none";
    }
}

function downloadFile(url) {
    fetch(url)
        .then((response) => response.blob())
        .then((blob) => {
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = url.split("/").pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch((error) => console.error("Download error:", error));
}

function cekFormat(input) {
    let value = input.value;
    let errorMsg = document.getElementById("error-msg");

    // Cek apakah semua huruf kapital kecuali huruf pertama
    if (value.length > 1 && value === value.toUpperCase()) {
        errorMsg.style.display = "inline";
        input.setCustomValidity(
            "Tidak boleh huruf besar semua, kecuali huruf pertama."
        );
    } else {
        errorMsg.style.display = "none";
        input.setCustomValidity(""); // Reset error jika valid
    }
}
