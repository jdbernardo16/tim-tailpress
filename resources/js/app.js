import Swiper from "swiper";
import { Navigation, Autoplay } from "swiper/modules";

// Mobile menu controller — runs on DOMContentLoaded equivalent
(function () {
    var toggle = document.getElementById('header-mobile-toggle');
    var menu = document.getElementById('header-mobile-menu');
    var iconOpen = document.getElementById('header-mobile-toggle-open');
    var iconClose = document.getElementById('header-mobile-toggle-close');
    var siteHeader = document.getElementById('site-header');

    if (!toggle || !menu) return;

    function setMenuOpen(open) {
        menu.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
        if (iconOpen) iconOpen.classList.toggle('hidden', open);
        if (iconClose) iconClose.classList.toggle('hidden', !open);
    }

    toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') !== 'true';
        setMenuOpen(open);
        if (open) {
            var firstLink = menu.querySelector('a');
            if (firstLink) firstLink.focus();
        }
    });

    var closeBtn = document.getElementById('header-mobile-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            setMenuOpen(false);
            toggle.focus();
        });
    }

    menu.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            // Don't close the menu when clicking a parent item with children
            // that isn't expanded yet (the submenu toggle handler handles it).
            var parent = a.parentElement;
            if (parent && parent.classList.contains('menu-item-has-children') && !parent.classList.contains('expanded')) {
                return;
            }
            setMenuOpen(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            toggle.focus();
        }
    });

    // Scroll header background
    if (siteHeader) {
        function updateHeader() {
            if (window.scrollY > 10) {
                siteHeader.classList.add('bg-navy/95', 'backdrop-blur-sm');
            } else {
                siteHeader.classList.remove('bg-navy/95', 'backdrop-blur-sm');
            }
        }
        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    }

    // Mobile submenu toggle (Work With Me and any other parent item)
    document.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth >= 960) return; // Desktop: normal navigation
            var parent = link.parentElement;
            if (parent.classList.contains('expanded')) {
                return; // Already expanded: navigate normally
            }
            // First click: expand
            e.preventDefault();
            parent.classList.add('expanded');
        });
    });
})();

window.addEventListener("load", function () {
    let mainNavigation = document.getElementById("primary-navigation");
    let mainNavigationToggle = document.getElementById("primary-menu-toggle");

    if (mainNavigation && mainNavigationToggle) {
        mainNavigationToggle.addEventListener("click", function (e) {
            e.preventDefault();
            mainNavigation.classList.toggle("hidden");
        });
    }

    // About Meaning Carousel
    const aboutMeaningSwiper = document.querySelector(".about-meaning-swiper");
    if (aboutMeaningSwiper) {
        new Swiper(aboutMeaningSwiper, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: ".about-meaning-swiper-button-next",
                prevEl: ".about-meaning-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
            },
        });
    }

    // On Stage Credibility Featured Carousel
    const onstageCredibilityFeaturedSwiper = document.querySelector(".onstage-credibility-featured-swiper");
    if (onstageCredibilityFeaturedSwiper) {
        new Swiper(onstageCredibilityFeaturedSwiper, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: ".onstage-credibility-featured-swiper-button-next",
                prevEl: ".onstage-credibility-featured-swiper-button-prev",
            },
        });
    }

    // Tell Your Story Carousel
    const tellStorySwiper = document.querySelector(".tell-story-swiper");
    if (tellStorySwiper) {
        new Swiper(tellStorySwiper, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: ".tell-story-swiper-button-next",
                prevEl: ".tell-story-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 16,
                },
            },
        });
    }

    // Tell Your Story Page Carousel
    const tellYourStorySwiper = document.querySelector(".tell-your-story-swiper");
    if (tellYourStorySwiper) {
        new Swiper(tellYourStorySwiper, {
            modules: [Navigation, Autoplay],
            slidesPerView: "auto",
            spaceBetween: 8,
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: ".tell-your-story-swiper-button-next",
                prevEl: ".tell-your-story-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 8,
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 8,
                },
            },
        });
    }

    // ============================================================
    // Inquiry Form — validation, GHL webhook submission, modal
    // ============================================================
    const inquiryForm = document.getElementById("inquiry-form");
    if (!inquiryForm) return;

    const modalEl = document.getElementById("inquiry-success-modal");
    const modalCloseBtn = document.getElementById("inquiry-modal-close");
    const modalOkayBtn = document.getElementById("inquiry-modal-okay");
    const submitBtn = document.getElementById("inquiry-submit");
    const btnText = submitBtn?.querySelector(".inquiry-btn-text");
    const btnSpinner = submitBtn?.querySelector(".inquiry-btn-spinner");

    /** Show an error message for a specific field. */
    function showFieldError(fieldName, message) {
        const errorEl = document.querySelector(`.inquiry-error[data-field="${fieldName}"]`);
        const inputEl = document.querySelector(`#inquiry-form [name="${fieldName}"]`);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.remove("hidden");
        }
        if (inputEl) inputEl.classList.add("inquiry-field-error");
    }

    /** Clear all field-level errors. */
    function clearAllErrors() {
        document.querySelectorAll(".inquiry-error").forEach((el) => {
            el.textContent = "";
            el.classList.add("hidden");
        });
        document.querySelectorAll(".inquiry-field-error").forEach((el) => {
            el.classList.remove("inquiry-field-error");
        });
    }

    /** Validate a single field, returns error string or empty string. */
    function validateField(name, value) {
        const trimmed = value.trim();
        switch (name) {
            case "full_name":
                return trimmed.length < 2 ? "Please enter your full name." : "";
            case "email":
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(trimmed) ? "" : "Please enter a valid email address.";
            case "phone":
                return trimmed.length > 0 && !/^[\d\s\-\+\(\)\.]{7,20}$/.test(trimmed)
                    ? "Please enter a valid phone number."
                    : "";
            case "message":
                return trimmed.length < 10 ? "Please write at least 10 characters." : "";
            default:
                return "";
        }
    }

    /** Validate the entire form. Returns true if valid. */
    function validateForm() {
        clearAllErrors();
        let isValid = true;
        const requiredFields = ["full_name", "email", "message"];
        requiredFields.forEach((name) => {
            const input = inquiryForm.querySelector(`[name="${name}"]`);
            const error = validateField(name, input?.value || "");
            if (error) {
                showFieldError(name, error);
                isValid = false;
            }
        });
        // Validate phone (optional but check format if filled)
        const phoneInput = inquiryForm.querySelector('[name="phone"]');
        if (phoneInput?.value.trim()) {
            const phoneError = validateField("phone", phoneInput.value);
            if (phoneError) {
                showFieldError("phone", phoneError);
                isValid = false;
            }
        }
        return isValid;
    }

    /** Set loading state on the submit button. */
    function setLoading(loading) {
        if (!submitBtn || !btnText || !btnSpinner) return;
        submitBtn.disabled = loading;
        btnText.classList.toggle("hidden", loading);
        btnSpinner.classList.toggle("hidden", !loading);
    }

    /** Show the success modal. */
    function showModal() {
        if (!modalEl) return;
        modalEl.classList.remove("hidden");
        modalEl.classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    /** Hide the success modal and reset the form. */
    function hideModalAndReset() {
        if (modalEl) {
            modalEl.classList.add("hidden");
            modalEl.classList.remove("flex");
        }
        document.body.style.overflow = "";
        inquiryForm.reset();
        clearAllErrors();
    }

    // Real-time validation on blur
    inquiryForm.querySelectorAll("input, textarea").forEach((el) => {
        el.addEventListener("blur", function () {
            const err = this.name === "phone" && !this.value.trim()
                ? "" // optional phone — skip when empty
                : validateField(this.name, this.value);
            const errorEl = document.querySelector(`.inquiry-error[data-field="${this.name}"]`);
            if (err) {
                showFieldError(this.name, err);
            } else {
                if (errorEl) { errorEl.textContent = ""; errorEl.classList.add("hidden"); }
                this.classList.remove("inquiry-field-error");
            }
        });
    });

    // Form submission
    inquiryForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        if (!validateForm()) return;

        const webhook = this.dataset.ghlWebhook;
        if (!webhook) {
            console.error("Inquiry form: missing GHL webhook URL");
            return;
        }

        const payload = {
            full_name: this.full_name.value.trim(),
            email: this.email.value.trim(),
            phone: this.phone.value.trim(),
            message: this.message.value.trim(),
        };

        setLoading(true);
        try {
            const response = await fetch(webhook, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload),
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            showModal();
        } catch (err) {
            console.error("Inquiry submission failed:", err);
            showFieldError("full_name", "Something went wrong. Please try again or contact us directly.");
        } finally {
            setLoading(false);
        }
    });

    // Modal close handlers
    modalCloseBtn?.addEventListener("click", hideModalAndReset);
    modalOkayBtn?.addEventListener("click", hideModalAndReset);

    // Close modal on overlay click
    modalEl?.addEventListener("click", function (e) {
        if (e.target === this) hideModalAndReset();
    });

    // Close modal on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modalEl && !modalEl.classList.contains("hidden")) {
            hideModalAndReset();
        }
    });
});

// ============================================================
// Newsletter Footer Form — validation, GHL webhook, modal
// ============================================================
window.addEventListener("load", function () {
    const newsletterForm = document.getElementById("footer-newsletter-form");
    if (!newsletterForm) return;

    const modalEl = document.getElementById("newsletter-success-modal");
    const modalCloseBtn = document.getElementById("newsletter-modal-close");
    const modalOkayBtn = document.getElementById("newsletter-modal-okay");
    const submitBtn = document.getElementById("newsletter-submit");
    const btnText = submitBtn?.querySelector(".newsletter-btn-text");
    const btnSpinner = submitBtn?.querySelector(".newsletter-btn-spinner");

    /** Show an error message for the email field. */
    function showEmailError(message) {
        const errorEl = document.querySelector(".newsletter-error[data-field='email']");
        const inputEl = document.querySelector("#footer-newsletter-form [name='email']");
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.remove("hidden");
        }
        if (inputEl) inputEl.classList.add("newsletter-field-error");
    }

    /** Clear email field error. */
    function clearEmailError() {
        const errorEl = document.querySelector(".newsletter-error[data-field='email']");
        const inputEl = document.querySelector("#footer-newsletter-form [name='email']");
        if (errorEl) {
            errorEl.textContent = "";
            errorEl.classList.add("hidden");
        }
        if (inputEl) inputEl.classList.remove("newsletter-field-error");
    }

    /** Validate email field. Returns error string or empty string. */
    function validateEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim())
            ? ""
            : "Please enter a valid email address.";
    }

    /** Set loading state on the submit button. */
    function setLoading(loading) {
        if (!submitBtn || !btnText || !btnSpinner) return;
        submitBtn.disabled = loading;
        btnText.classList.toggle("hidden", loading);
        btnSpinner.classList.toggle("hidden", !loading);
    }

    /** Show the success modal. */
    function showModal() {
        if (!modalEl) return;
        modalEl.classList.remove("hidden");
        modalEl.classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    /** Hide the success modal and reset the form. */
    function hideModalAndReset() {
        if (modalEl) {
            modalEl.classList.add("hidden");
            modalEl.classList.remove("flex");
        }
        document.body.style.overflow = "";
        newsletterForm.reset();
        clearEmailError();
    }

    // Real-time email validation on blur
    const emailInput = newsletterForm.querySelector('[name="email"]');
    if (emailInput) {
        emailInput.addEventListener("blur", function () {
            const err = validateEmail(this.value);
            if (err) {
                showEmailError(err);
            } else {
                clearEmailError();
            }
        });
        // Clear error on input (while typing)
        emailInput.addEventListener("input", function () {
            const errorEl = document.querySelector(".newsletter-error[data-field='email']");
            if (errorEl && !errorEl.classList.contains("hidden")) {
                const err = validateEmail(this.value);
                if (!err) clearEmailError();
            }
        });
    }

    // Form submission
    newsletterForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        clearEmailError();

        const email = this.email.value.trim();
        const error = validateEmail(email);
        if (error) {
            showEmailError(error);
            return;
        }

        const webhook = this.dataset.ghlWebhook;
        if (!webhook) {
            console.error("Newsletter form: missing GHL webhook URL");
            return;
        }

        const payload = { email };

        setLoading(true);
        try {
            const response = await fetch(webhook, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload),
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            showModal();
        } catch (err) {
            console.error("Newsletter submission failed:", err);
            showEmailError("Something went wrong. Please try again.");
        } finally {
            setLoading(false);
        }
    });

    // Modal close handlers
    modalCloseBtn?.addEventListener("click", hideModalAndReset);
    modalOkayBtn?.addEventListener("click", hideModalAndReset);

    // Close modal on overlay click
    modalEl?.addEventListener("click", function (e) {
        if (e.target === this) hideModalAndReset();
    });

    // Close modal on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modalEl && !modalEl.classList.contains("hidden")) {
            hideModalAndReset();
        }
    });
});
