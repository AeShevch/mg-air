<h1 style="margin: 0 0 10px 0; font-size: 16px;padding: 0;">
    Вы получили ответ на оставленный отзыв на сайте <?php echo $data['siteName'] ?>.
</h1>
<p style="padding: 0;margin: 10px 0;font-size: 12px;">
    Объект отзыва: <a target="_blank" href="<?php echo $data['commentUrl']; ?>"><?php echo $data['commentUrl'] ?></a>
<p style="padding: 0;margin: 10px 0;font-size: 12px;">
  Для того, чтобы отписаться от уведомлений, перейдите по этой <a target="_blank" href="<?php echo $data['unsubscribeUrl']; ?>">ссылке</a>.
</p>