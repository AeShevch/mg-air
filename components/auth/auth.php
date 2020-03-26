<?php
/*
 * Ссылка, ведущая в личный кабинет, если пользователь авторизован,
 * либо на страницу авторизрации, если нет.
 *
 * */

mgAddMeta('components/auth/auth.css'); ?>
<div class="a-auth">
    <?php
    // Получаем информацию о пользователе
    $userArr = (array)USER::getThis();

    if (!empty($userArr)): ?>
        <a class="a-auth__link"
           title="<?php echo lang('Personal_page') ?>"
           href="<?php echo SITE ?>/personal">
            <?php echo lang('Personal_page') ?>
        </a>
    <?php else: ?>
        <a class="a-auth__link"
           title="<?php echo lang('enterEnter') ?>"
           href="<?php echo SITE ?>/enter">
            <?php echo lang('enterEnter') ?>
        </a><span class="a-auth__delimiter">/</span>
        <a class="a-auth__link a-auth__link_register"
           title="<?php echo lang('enterRegister') ?>"
           href="<?php echo SITE ?>/registration">
            <?php echo lang('enterRegister') ?>
        </a>
    <?php endif; ?>
</div>
