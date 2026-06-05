<?php

/**
 * Tell Your Story Page - Exit-Intent Modal template part.
 *
 * @package TailPress
 */

$webhook_url = 'https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/ed78846f-c6f9-4e59-8c42-13a8aebe2798';
?>

<div class="fixed inset-0 z-[9999] flex items-center justify-center p-5 opacity-0 invisible transition-all duration-400 ease-in-out"
     id="tysExitModal"
     style="background: rgba(15, 32, 61, 0.7); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
    <div class="bg-white rounded-[24px] max-w-[580px] w-full max-h-[100vh] overflow-y-auto p-8 sm:p-10 lg:p-12 relative shadow-2xl transform translate-y-8 scale-[0.97] transition-transform duration-400 ease-in-out"
         id="tysModalCard">
        <!-- Close Button -->
        <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-[#f0ede6] border-none cursor-pointer flex items-center justify-center hover:bg-[#e0dbd0] transition-colors"
                id="tysModalClose" aria-label="Close popup">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M18 6L6 18M6 6L18 18" stroke="#1e1e1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- Form View -->
        <div id="tysModalForm">
            <span class="inline-flex items-center font-flatline text-[11px] font-bold uppercase tracking-[0.2em] text-gold bg-gold/15 rounded-[20px] px-4 py-1.5 mb-4">
                STAY IN THE LOOP
            </span>
            <h2 class="font-flatline font-semibold text-2xl sm:text-[28px] text-navy leading-[1.2] mb-2">Before You Go…</h2>
            <p class="font-garet text-[15px] font-light text-[#555] leading-[1.5] mb-7">
                Join the <strong>True Influence Method</strong> email list to receive insights, stories, and message-building strategies straight to your inbox.
            </p>

            <form id="tysModalForm" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="font-flatline text-[13px] font-semibold text-navy tracking-[0.03em]" for="tysModalName">Name</label>
                    <input class="w-full px-4 py-3.5 border border-[#e0dbd0] rounded-[12px] font-garet text-[15px] text-dark-text bg-[#faf8f4] outline-none transition-all focus:border-gold focus:shadow-[0_0_0_3px_rgba(212,180,120,0.15)] focus:bg-white"
                           type="text" id="tysModalName" name="name" placeholder="Your full name" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="font-flatline text-[13px] font-semibold text-navy tracking-[0.03em]" for="tysModalPhone">Phone</label>
                    <input class="w-full px-4 py-3.5 border border-[#e0dbd0] rounded-[12px] font-garet text-[15px] text-dark-text bg-[#faf8f4] outline-none transition-all focus:border-gold focus:shadow-[0_0_0_3px_rgba(212,180,120,0.15)] focus:bg-white"
                           type="tel" id="tysModalPhone" name="phone" placeholder="(555) 123-4567" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="font-flatline text-[13px] font-semibold text-navy tracking-[0.03em]" for="tysModalEmail">Email</label>
                    <input class="w-full px-4 py-3.5 border border-[#e0dbd0] rounded-[12px] font-garet text-[15px] text-dark-text bg-[#faf8f4] outline-none transition-all focus:border-gold focus:shadow-[0_0_0_3px_rgba(212,180,120,0.15)] focus:bg-white"
                           type="email" id="tysModalEmail" name="email" placeholder="you@example.com" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="font-flatline text-[13px] font-semibold text-navy tracking-[0.03em]" for="tysModalMessage">
                        What's the message you struggle most to put into words?
                    </label>
                    <textarea class="w-full px-4 py-3.5 border border-[#e0dbd0] rounded-[12px] font-garet text-[15px] text-dark-text bg-[#faf8f4] outline-none transition-all focus:border-gold focus:shadow-[0_0_0_3px_rgba(212,180,120,0.15)] focus:bg-white resize-y min-h-[100px]"
                              id="tysModalMessage" name="message" placeholder="Share what's on your heart…" rows="4"></textarea>
                </div>

                <div class="flex items-start gap-2.5 mt-1">
                    <input type="checkbox" id="tysModalConsent" name="consent" required class="w-[18px] h-[18px] min-w-[18px] mt-0.5 accent-gold cursor-pointer">
                    <label for="tysModalConsent" class="font-garet text-xs font-light text-[#777] leading-[1.5] cursor-pointer">
                        By checking this box, I agree to receive marketing and informational emails, SMS text messages, and phone calls from True Influence Method™️ at the contact info provided, including via automated technology. Consent is not a condition of purchase. Message and data rates may apply. Message frequency varies. Reply STOP to opt out.
                    </label>
                </div>

                <button type="submit" class="tys-modal-submit w-full py-4 px-6 rounded-[40px] font-flatline font-bold text-base text-navy cursor-pointer transition-transform hover:-translate-y-0.5 hover:shadow-lg mt-2 border-0"
                        style="background: radial-gradient(circle at center, #e7d4c5, #d4b478);">
                    SUBSCRIBE
                </button>
            </form>
        </div>

        <!-- Success View -->
        <div class="hidden text-center py-8 px-4" id="tysModalSuccess">
            <div class="w-14 h-14 mx-auto mb-5 bg-gold rounded-full flex items-center justify-center">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="font-flatline font-semibold text-[22px] text-navy mb-2">You're Subscribed!</h3>
            <p class="font-garet text-[15px] font-light text-[#555]">
                Welcome to the <strong>True Influence Method</strong> community. Check your inbox for a welcome email — we're glad to have you.
            </p>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    var overlay = document.getElementById('tysExitModal');
    var card = document.getElementById('tysModalCard');
    var closeBtn = document.getElementById('tysModalClose');
    var form = document.getElementById('tysModalForm');
    var formView = document.getElementById('tysModalForm');
    var successView = document.getElementById('tysModalSuccess');
    var consentCheck = document.getElementById('tysModalConsent');
    var shown = false;
    var submitted = false;

    // --- Show modal after 3 seconds ---
    setTimeout(function() {
        if (!shown) {
            shown = true;
            overlay.style.opacity = '1';
            overlay.style.visibility = 'visible';
            card.style.transform = 'translateY(0) scale(1)';
            document.body.style.overflow = 'hidden';
        }
    }, 3000);

    // --- Close handlers ---
    function closeModal() {
        overlay.style.opacity = '0';
        overlay.style.visibility = 'hidden';
        card.style.transform = 'translateY(30px) scale(0.97)';
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeModal);

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            closeModal();
        }
    });

    // --- Escape key ---
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && overlay.style.visibility === 'visible') {
            closeModal();
        }
    });

    // --- Form submit ---
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (submitted) return;

        var name = document.getElementById('tysModalName').value.trim();
        var phone = document.getElementById('tysModalPhone').value.trim();
        var email = document.getElementById('tysModalEmail').value.trim();
        var message = document.getElementById('tysModalMessage').value.trim();

        if (!name || !phone || !email) {
            alert('Please fill in your name, phone, and email.');
            return;
        }

        if (!consentCheck.checked) {
            alert('Please agree to the consent terms.');
            return;
        }

        submitted = true;

        var submitBtn = form.querySelector('.tys-modal-submit');
        var originalText = submitBtn.textContent;
        submitBtn.textContent = 'SUBMITTING…';
        submitBtn.disabled = true;

        var payload = { name: name, phone: phone, email: email, message: message };

        fetch('<?php echo esc_url($webhook_url); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
        .then(function(response) {
            if (!response.ok) throw new Error('Server responded with ' + response.status);
            return response.text();
        })
        .then(function() {
            formView.style.display = 'none';
            successView.classList.remove('hidden');
            successView.style.display = 'block';

            setTimeout(function() {
                closeModal();
                setTimeout(function() {
                    formView.style.display = '';
                    successView.style.display = 'none';
                    successView.classList.add('hidden');
                    form.reset();
                    submitted = false;
                    shown = false;
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }, 400);
            }, 4000);
        })
        .catch(function(err) {
            console.error('Submission failed:', err);
            alert('Something went wrong. Please try again.');
            submitted = false;
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
})();
</script>
