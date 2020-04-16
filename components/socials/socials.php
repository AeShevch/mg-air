<?php mgAddMeta('components/socials/socials.css'); ?>
<nav class="a-socials">
    <ul class="a-socials__list">
        <?php if (MG::get('templateParams')['SOCIALS']['checkbox_footerFacebook'] === 'true'): ?>
        <li class="a-socials__item">
            <a class="a-socials__link a-socials__link_fb"
               target="_blank"
               title="<?php echo MG::get('templateParams')['SOCIALS']['footerFbTitle'] ?>"
               href="<?php echo MG::get('templateParams')['SOCIALS']['footerFacebookUrl'] ?>"></a>
        </li>
        <?php endif; ?>
        <?php if (MG::get('templateParams')['SOCIALS']['checkbox_footerVk'] === 'true'): ?>
        <li class="a-socials__item">
            <a class="a-socials__link a-socials__link_vk"
               target="_blank"
               title="<?php echo MG::get('templateParams')['SOCIALS']['footerVkTitle'] ?>"
               href="<?php echo MG::get('templateParams')['SOCIALS']['footerVkUrl'] ?>">
                <svg>
                    <use xlink:href="#icon_vk"></use>
                </svg>
            </a>
        </li>
        <?php endif; ?>
        <?php if (MG::get('templateParams')['SOCIALS']['checkbox_footerInstagram'] === 'true'): ?>
        <li class="a-socials__item">
            <a class="a-socials__link a-socials__link_inst"
               target="_blank"
               title="<?php echo MG::get('templateParams')['SOCIALS']['footerIgTitle'] ?>"
               href="<?php echo MG::get('templateParams')['SOCIALS']['footerInstagramUrl'] ?>"></a>
        </li>
        <?php endif; ?>
        <?php if (MG::get('templateParams')['SOCIALS']['checkbox_footerPntrst'] === 'true'): ?>
        <li class="a-socials__item">
            <a class="a-socials__link a-socials__link_pntrst"
               target="_blank"
               title="<?php echo MG::get('templateParams')['SOCIALS']['footerPntrstTitle'] ?>"
               href="<?php echo MG::get('templateParams')['SOCIALS']['footerPntrstUrl'] ?>"></a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
