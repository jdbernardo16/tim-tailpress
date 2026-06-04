<?php

/**
 * On Stage Page - Credibility Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_credibility_heading');
?>

<section class="bg-canvas px-4 sm:px-10">
    <div class="relative overflow-hidden rounded-[20px] bg-navy">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.webp" alt="">
        </div>

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3"></div>
            <div class="absolute top-0 left-0 w-[1525px] h-[1525px] bg-gold/10 rounded-full blur-3xl transform -translate-x-2/3 -translate-y-2/3"></div>
        </div>

        <div class="absolute -top-3 left-1/2 -translate-x-1/2 pointer-events-none select-none">
            <h2 class="font-flatline font-bold text-[117px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/0 opacity-20">
                CREDIBILITY
            </h2>
        </div>

        <div class="relative max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center mb-20">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-tight">
                    <?= $heading ?>
                </h2>
            </div>

            <?php if (have_rows('section_credibility_items')): ?>
                <div class="flex flex-col gap-6">
                    <?php $item_count = 0; ?>
                    <?php while (have_rows('section_credibility_items')): the_row(); ?>
                        <?php if ($item_count % 4 === 0): ?>
                            <?php if ($item_count > 0): ?>
                    </div>
                            <?php endif; ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                        <?php endif; ?>
                        <div class="rounded-[10px] bg-white/15 backdrop-blur-[9px] border border-gold p-5 min-h-[201px] flex flex-col">
                            <h4 class="font-flatline font-semibold text-gold text-lg leading-[110%] flex-1">
                                <?php echo esc_html(get_sub_field('item_heading')); ?>
                            </h4>
                            <p class="font-garet text-white text-sm mt-6">
                                <?php echo esc_html(get_sub_field('item_text')); ?>
                            </p>
                        </div>
                        <?php $item_count++; ?>
                    <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
