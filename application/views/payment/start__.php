

<?php if(true) : ?>
<div class="status"></div>
<style>
label {font-size: 1.1em; font-weight: normal;}
label p {font-size: 0.8em; color: gray; margin: 2px 0;}
input[type='radio'] {vertical-align: top;}

#calculatedPoints {margin-top: 8px;}
#calculatedPoints > span {font-weight: bold;}
</style>

<p style="margin: 15px 0; color: green;">Обработка платежей происходит в автоматическом режиме, баллы будут зачислены сразу после оплаты.</p>
<p style="margin: 15px 0; opacity: 0.6;">Совершая оплату, вы подтверждаете что ознакомились и согласны с <a href="<?=site_url('info/rules');?>">Правилами сервиса</a>.</p>

<?php 
$submit = '<input type="submit" class="btn btn-success" value="Оплатить"> или <a href="'.site_url('payment/start').'">отменить</a>';

$system = function($system) {
  switch($system) {
    case 'AC': 
      return 'Банковские карты';
    case 'PC':
      return 'Яндекс.Деньги';
    case 'wmr':
      return 'Webmoney WMR';
    case 'w1':
      return 'WalletOne';
  }
}
?>

<?php if(isset($order)) : ?>
  <table class="table table-striped table-bordered table-hover" style="width: 300px;">
    <tr><td>Номер заказа</td> <td><?php echo $order['id']; ?></td></tr>
    <tr><td>ID пользователя</td> <td><?php echo $order['user_id']; ?></td></tr>
    <tr><td>Метод оплаты</td><td><?php echo $system($order['system']); ?></td></tr>
    <tr><td>Сумма оплаты</td> <td><?php echo $order['sum']; ?> р.</td></tr>
  </table>

  <?php if(($order['system'] == 'AC' OR $order['system'] == 'PC')) : ?>

  <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> 
    <input type="hidden" name="receiver" value="410019870411990"> 
    <input type="hidden" name="formcomment" value="YTuber.ru: Пополнение баланса"> 
    <input type="hidden" name="label" value="<?php echo $order['id']; ?>-<?php echo $order['user_id']; ?>"> 
    <input type="hidden" name="quickpay-form" value="shop"> 
    <input type="hidden" name="targets" value="Пополнение баланса пользователя #<?php echo $order['user_id']; ?> на сумму <?php echo $order['sum']; ?> р."> 
    <input type="hidden" name="paymentType" value="<?php echo ($order['system'] == 'AC') ? 'AC' : 'PC'; ?>"> 
    <input type="hidden" name="sum" value="<?php echo $order['sum']; ?>"> 
    <?php echo $submit; ?>
  </form>

  <?php elseif(isset($system) && $order['system'] == 'wmr') : ?>

  <form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset="windows-1251" >
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo $order['sum']; ?>" />
    <input type="hidden" name="LMI_PAYMENT_DESC" value="Пополнение баланса пользователя #<?php echo $order['user_id']; ?> на сумму <?php echo $order['sum']; ?> р." />
    <input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $order['id']; ?>">
    <input type="hidden" name="LMI_PAYEE_PURSE" value="R384856904150" />
    <input type="hidden" name="LMI_SIM_MODE" value="0" />
    <input type="hidden" name="USER_ID" value="<?php echo $order['user_id']; ?>" />
    <?php echo $submit; ?>
  </form>

  <?php elseif(isset($system) && $order['system'] == 'w1') : ?>
    <?php echo str_replace('[submit]', $submit, $w1_form); ?>
  <?php endif; ?>

<?php else : ?>

<form method="POST" action="/payment/start" id="paymentForm">
  <div class="form-group">
    <h4>Метод оплаты</h4>
    <input type="radio" name="system" value="AC" id="type_cart" checked /> <label for="type_cart">Банковской картой <p>Visa, MasterCard</p></label> <br/>
    <input type="radio" name="system" value="PC" id="type_yd" /> <label for="type_yd">Яндекс.Деньгами<p style="height: 3px;"></p></label><br/>


    <input type="radio" name="system" value="wmr" id="type_wmr" /> <label for="type_wmr">Webmoney <p>С кошельков WMR</p></label><br/>

    <?php if(false) : ?>
    <input type="radio" name="system" value="W1" id="type_w1" /> <label for="type_w1">WalletOne <p>Qiwi, Альфа Клик, Сбербанк Онлайн, Приват 24 и др.</p></label><br/>
    <input type="radio" name="system" value="Test" id="type_test" /> <label for="type_test">Test</label><br/>
    <?php endif; ?>
  </div>

    <div class="row" style="margin: 30px 0;">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="sum">Сумма оплаты (р.)</label>
                <input class="form-control" name="sum" type="number" min="100" max="10000" value="100" step="100"/>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Кол-во получаемых баллов</label>
                <p id="calculatedPoints">Вы получите <span>750</span> баллов</p>
            </div>
        </div>
    </div>


  <input type="submit" class="btn btn-success" name="submit-button" value="Продолжить"> 

</form>
<?php endif; ?>

<?php endif; ?>
