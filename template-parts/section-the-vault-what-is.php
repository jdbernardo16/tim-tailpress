<?php

/**
 * The Vault Page - What Is Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_what_is_heading') ?: "What is the <em>Vault?</em>";
$what_is_text = get_field('section_what_is_text');
$what_is_image_id = get_field('section_what_is_image');

$paragraphs = array(
    "The Vault is Joanna's free live conversation space for women exploring voice, visibility, leadership, and emotional truth.",
    "A place for honest reflection, real questions, and the conversations that usually happen after the stage lights go down.",
    "No performance. No pressure. Just space to reconnect with what's real.",
);
?>
<section class="bg-canvas py-24 lg:py-28">
    <div class="max-w-[1230px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-16">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($what_is_text): ?>
                    <div class="mt-8 font-garet text-lg text-dark-text leading-[1.5]">
                        <?= wpautop($what_is_text) ?>
                    </div>
                <?php else: ?>
                    <div class="mt-8 space-y-4">
                        <?php foreach ($paragraphs as $paragraph) : ?>
                            <p class="font-garet text-lg text-dark-text leading-[1.5]">
                                <?php echo esc_html($paragraph); ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php if ($what_is_image_id): ?>
                    <?= wp_get_attachment_image($what_is_image_id, 'full', false, ['class' => 'w-full h-[356px] object-cover rounded-[10px]', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-what-is.webp" alt="Joanna Horton McPherson" class="w-full h-[356px] object-cover rounded-[10px]">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
