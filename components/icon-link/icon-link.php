<?php mgAddMeta('components/icon-link/icon-link.css'); ?>
<a class="a-icon-link" href="<?php $data['link']; ?>" title="<?php echo $data['title']; ?>">
    <svg class="a-icon-link__svg" width="40" height="30">
        <use xlink:href="<?php echo $data['iconId']; ?>"></use>
    </svg>
    <span class="a-icon-link__title">
        <?php echo $data['title']; ?>
    </span>
</a>
