<?php

/**
 * The Vault Page - What Is Section template part.
 *
 * @package TailPress
 */

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
                    What is the <em class="text-gold italic">Vault?</em>
                </h2>

                <div class="mt-8 space-y-4">
                    <?php foreach ($paragraphs as $paragraph) : ?>
                        <p class="font-garet text-lg text-dark-text leading-[1.5]">
                            <?php echo esc_html($paragraph); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-what-is.webp" alt="Joanna Horton McPherson" class="w-full h-[356px] object-cover rounded-[10px]">
            </div>
        </div>
    </div>
</section>
