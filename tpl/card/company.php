<?php
use GDO\Nasdax\NDX_Company;
use GDO\User\User;

$company instanceof NDX_Company;
$user = User::current();
?>
<md-card class="ndx-company">
  <md-card-title>
    <md-card-title-text>
      <span class="md-headline">
        <div>“<?= $company->getName(); ?>”</div>
      </span>
    </md-card-title-text>
  </md-card-title>
  <gdo-div></gdo-div>
  <md-card-content flex>
    <div><?= t('symbol') ?>: <?= $company->getSymbol() ?></div>
  </md-card-content>
  <gdo-div></gdo-div>
  <md-card-actions layout="row" layout-align="end center">
  </md-card-actions>
</md-card>
