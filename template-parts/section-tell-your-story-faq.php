<?php

/**
 * Tell Your Story Page - FAQ Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_tys_faq_heading') ?: 'Frequently Asked<br><em class="text-gold italic">Questions</em>';

$faqs = array(
    array(
        'question' => 'What happens during the retreat?',
        'answer'   => 'Tell Your Story is an immersive transformational experience designed to help leaders reconnect with the story behind their voice, leadership, and influence. Through guided reflection, live story sharing, emotional feedback, and intimate group experiences, participants begin clarifying the message that feels most true to who they are.',
    ),
    array(
        'question' => 'Do I need speaking experience?',
        'answer'   => 'No. This experience is not about becoming a polished performer. It\'s about reconnecting with the truth behind your voice so your message feels more grounded, clear, and emotionally honest.',
    ),
    array(
        'question' => 'Is this for leaders or speakers?',
        'answer'   => 'Both. Tell Your Story is designed for leaders, founders, visionaries, and speakers who want to communicate with deeper trust, clarity, and emotional connection.',
    ),
    array(
        'question' => 'What\'s included?',
        'answer'   => 'Your investment includes the transformational course experience, retreat sessions, guided exercises, live story work, and immersive group experiences throughout the retreat. Travel and accommodations are not included.',
    ),
    array(
        'question' => 'Is travel included?',
        'answer'   => 'No. Travel and accommodations are separate so participants can choose the arrangements that best support their experience.',
    ),
    array(
        'question' => 'What if I\'m not fully clear on my message yet?',
        'answer'   => 'That\'s exactly why this experience exists. Tell Your Story is designed for people who know there\'s something deeper they want to communicate — even if they don\'t fully have the words for it yet.',
    ),
);

if (have_rows('section_tys_faq_items')) {
    $faqs = array();
    while (have_rows('section_tys_faq_items')) {
        the_row();
        $faqs[] = array(
            'question' => get_sub_field('question'),
            'answer'   => get_sub_field('answer'),
        );
    }
}
?>

<section class="py-24 lg:py-28 px-5 bg-canvas">
    <div class="max-w-[1100px] mx-auto flex flex-col lg:flex-row items-start gap-12 lg:gap-20">
        <!-- Left -->
        <div class="w-full lg:w-[40%] flex-shrink-0">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                <?= $heading ?>
            </h2>
        </div>

        <!-- Right: FAQ Items -->
        <div class="flex-1 w-full">
            <?php $first = true; ?>
            <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-item border-t border-navy/15 <?= $first ? 'open' : '' ?>" data-index="<?= $index ?>">
                    <button class="faq-question-btn w-full bg-transparent border-none py-6 flex items-center justify-between gap-4 cursor-pointer font-garet text-lg font-medium text-navy text-left">
                        <span><?= esc_html($faq['question']) ?></span>
                        <span class="faq-icon relative w-6 h-6 flex-shrink-0">
                            <span class="absolute top-1/2 left-0 right-0 h-0.5 bg-navy -translate-y-1/2 transition-transform"></span>
                            <span class="faq-icon-v absolute top-0 bottom-0 left-1/2 w-0.5 bg-navy -translate-x-1/2 transition-transform duration-300"></span>
                        </span>
                    </button>
                    <div class="faq-answer overflow-hidden transition-all duration-300 max-h-0" style="max-height: 0;">
                        <div class="bg-navy text-white p-6 sm:p-7 rounded-[12px] font-garet text-base font-light leading-[1.6] mb-4">
                            <?= esc_html($faq['answer']) ?>
                        </div>
                    </div>
                </div>
                <?php $first = false; ?>
            <?php endforeach; ?>
            <div class="border-t border-b border-navy/15 h-0"></div>
        </div>
    </div>

    <script>
    (function() {
        var items = document.querySelectorAll('.faq-item');
        items.forEach(function(item) {
            var btn = item.querySelector('.faq-question-btn');
            var answer = item.querySelector('.faq-answer');
            btn.addEventListener('click', function() {
                var isOpen = item.classList.contains('open');

                // Close all
                items.forEach(function(i) {
                    i.classList.remove('open');
                    var a = i.querySelector('.faq-answer');
                    if (a) a.style.maxHeight = '0';
                });

                // Open clicked if it was closed
                if (!isOpen) {
                    item.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + 80 + 'px';
                }
            });

            // Set initial state for first item
            if (item.classList.contains('open')) {
                var a = item.querySelector('.faq-answer');
                if (a) a.style.maxHeight = a.scrollHeight + 80 + 'px';
            }
        });
    })();
    </script>
</section>
