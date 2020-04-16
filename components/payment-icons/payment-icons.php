<?php
mgAddMeta('components/payment-icons/payment-icons.css');

$paymentIdToIconName = [
  '1' => 'webmoney.png',
  '2' => 'ya.png',
  '12' => 'ya.png',
  '5' => 'robo.png',
  '6' => 'qiwi.png',
  '8' => 'sci.png',
  '9' => 'payanyway.png',
  '10' => 'paymaster.png',
  '11' => 'alfabank.png',
  '14' => 'yandexkassa.png',
  '15' => 'privat24.png',
  '16' => 'liqpay.png',
  '17' => 'sber.png',
  '18' => 'tinkoff.png',
  '19' => 'paypal.png',
  '21' => 'paykeeper.png',
  '20' => 'comepay.svg',
  '22' => 'cloudpayments.png',
  '23' => 'ya-pay-parts.svg',
  '24' => 'yandexkassa.png',
  '25' => 'apple.png',
  '26' => 'free-kassa.png',
  '27' => 'megakassa.png',
  '28' => 'qiwi.png',
];

if (MG::get('templateParams')['FOOTER']['checkbox_paymentShow'] === 'true') :?>
    <div class="a-footer-payments">
        <?php
        $res = DB::query(
          'SELECT name, id FROM ' .
          PREFIX .
          'payment WHERE activity=1 ORDER BY id'
        ); ?>

        <ul class="a-footer-payments__list">
            <?php while ($payments = DB::fetchAssoc($res)) {
            $imgName = isset($paymentIdToIconName[$payments['id']]) ? $paymentIdToIconName[$payments['id']] : 'cash.png';
            ?>
            <li title="Доступен способ оплаты «<?php echo $payments['name']; ?>»"
                class="a-footer-payments__item a-footer-payments__item_id_<?php echo $payments['id']; ?>">
                <img loading="lazy"
                     src="<?php echo SITE . '/mg-admin/design/images/icons/' . $imgName; ?>"
                     alt="Доступен способ оплаты «<?php echo $payments['name']; ?>»">
            </li>
            <?php } ?>
        </ul>
    </div>
<?php endif ; ?>
