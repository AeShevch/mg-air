<?php
mgAddMeta('components/shop-settings/shop-settings.css');
mgAddMeta('components/shop-settings/shop-settings.js');

// Подготавливаем данные
$settingsArray = [];

$settingsArray[0]['title'] = 'Язык/Валюта';
$settingsArray[0]['link'] = '';
$settingsArray[0]['content'][0]['title'] = 'Язык';
$settingsArray[0]['content'][0]['type'] = 'lang';
$settingsArray[0]['content'][0]['items'] = unserialize(stripcslashes(MG::getSetting('multiLang')));
console_log($settingsArray[0]['content'][0]['items']);
foreach ($settingsArray[0]['content'][0]['items'] as $key => $item) {
    if (!$item['active'] === 'true' ||!$item['enabled'] === 'true') continue;
    $settingsArray[0]['content'][0]['items'][$key]['title'] = $item['full'];
}

if (MG::getSetting('printCurrencySelector') == 'true') {
    $settingsArray[0]['content'][1]['title'] = 'Валюта';
    $settingsArray[0]['content'][1]['type'] = 'curr';
    $currencies = MG::getSetting('currencyShort');
    foreach ($currencies as $key => $item) {
        $settingsArray[0]['content'][1]['items'][$key]['title'] = $currencies[$key];
        $settingsArray[0]['content'][1]['items'][$key]['activity'] = $currencies[$key] === $data['currency'] ? true : false;
        $settingsArray[0]['content'][1]['items'][$key]['class'] = 'js-curr-select';
    }
}

component(
  'mega-menu',
  ['id' => 'shop-settings', 'items' => $settingsArray],
  'simple-menu'
);
