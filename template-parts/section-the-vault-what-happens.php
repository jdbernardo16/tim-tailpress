<?php

/**
 * The Vault Page - What Happens Inside Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_what_happens_heading') ?: "What <em>Happens</em> Inside";

$items = array(
    'Live conversation with Joanna',
    'Real-time reflection and guidance',
    'Message clarity and refinement',
    'Honest conversations around visibility, leadership, and truth',
    'A space to ask the question you haven&#8217;t fully said out loud yet',
);
?>
<section class="bg-canvas pb-24 lg:pb-28">
    <div class="max-w-[1230px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-what-happens.webp" alt="Joanna Horton McPherson" class="w-full h-[458px] object-cover rounded-[10px]">
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if (have_rows('section_what_happens_items')): ?>
                    <ul class="mt-8 space-y-4">
                        <?php while (have_rows('section_what_happens_items')): the_row(); ?>
                            <?php
                            $item_heading = get_sub_field('item_heading');
                            $item_text = get_sub_field('item_text');
                            ?>
                            <li class="flex items-start gap-4">
                                <svg class="w-6 h-6 flex-shrink-0 mt-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="7" cy="7" r="3" fill="#d4b478" />
                                    <circle cx="17" cy="7" r="3" fill="#d4b478" />
                                    <circle cx="7" cy="17" r="3" fill="#d4b478" />
                                    <circle cx="17" cy="17" r="3" fill="#d4b478" />
                                </svg>
                                <span class="font-garet text-lg text-dark-text leading-[1.5]">
                                    <?= esc_html($item_heading) ?>
                                    <?php if ($item_text): ?>
                                        <br><span class="text-base opacity-80"><?= esc_html($item_text) ?></span>
                                    <?php endif; ?>
                                </span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[1.5] italic">
                    The Vault exists for women who know there is something important inside them — but haven&#8217;t fully found the language for it yet.
                </p>
            </div>
        </div>
    </div>
</section>
