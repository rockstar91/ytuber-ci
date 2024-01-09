<?php if (true) : ?>
    <div class="status"></div>
    <style>
        label {
            font-size: 1.1em;
            font-weight: normal;
        }

        label p {
            font-size: 0.8em;
            color: gray;
            margin: 2px 0;
        }

        input[type='radio'] {
            vertical-align: top;
        }

        #calculatedPoints {
            margin-top: 8px;
        }

        #calculatedPoints > span {
            font-weight: bold;
        }
    </style>

    <p style="margin: 15px 0; color: green;">Обработка платежей происходит в автоматическом режиме, баллы будут
        зачислены сразу после оплаты.</p>

    <?php
    $submit = '<input type="submit" class="btn btn-success" value="Оплатить"> или <a href="' . site_url('payment/start') . '">отменить</a>';
    ?>

    <?php if (isset($order)) : ?>
        <table class="table table-striped table-bordered table-hover" style="width: 300px;">
            <tr>
                <td>Номер заказа</td>
                <td><?php echo $order['id']; ?></td>
            </tr>
            <tr>
                <td>ID пользователя</td>
                <td><?php echo $order['user_id']; ?></td>
            </tr>
            <tr>
                <td>Метод оплаты</td>
                <td><?php echo $paymentSystem->name; ?></td>
            </tr>
            <tr>
                <td>Сумма оплаты</td>
                <td><?php echo $order['sum']; ?> р.</td>
            </tr>
        </table>

        <?php echo str_replace('[submit]', $submit, $paymentForm); ?>

    <?php else : ?>

        <form method="POST" action="/payment/start" id="paymentForm">
            <div class="form-group">
                <h4>Метод оплаты</h4>
                <?php foreach ($paymentSystemList as $paymentSystem) : ?>
                <?php if($paymentSystem->id != 55) : ?>
                    <div <?php if(false) : ?> style="display: none;"<?php endif;?>> 
                        <input type="radio" name="payment_system_id" value="<?=$paymentSystem->id;?>" id="payment_system_<?=$paymentSystem->id;?>"/>
                        <label for="payment_system_<?=$paymentSystem->id;?>">
                            <?=$paymentSystem->name;?>
                            <p><?=$paymentSystem->description;?></p>
                        </label> <br/>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="row" style="margin: 10px 0;">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="sum">Сумма оплаты (р.)</label>
                        <input class="form-control" name="sum" type="number" min="100" max="10000" value="500"
                               step="100"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Кол-во получаемых баллов</label>
                        <p id="calculatedPoints">Вы получите <span>11250</span> баллов</p>
                    </div>
                </div>
            </div>
		
		<div class="row">
			<div class="col-sm-12">
		    <p style="margin: 15px 0; opacity: 0.8;">Совершая оплату, вы подтверждаете что ознакомились и согласны с <a
                href="<?= site_url('info/rules'); ?>">Правилами сервиса</a>.</p>
			</div>
		</div>

            <input type="submit" class="btn btn-success" name="submit-button" value="Продолжить">

        </form>
    <?php endif; ?>

<?php endif; ?>




<?php if (isset($system) && ($order['system'] == 'AC' OR $order['system'] == 'PC')) : ?>

    <form method="POST" action="">
        <input type="hidden" name="receiver" value="">
        <input type="hidden" name="formcomment" value="YTuber.ru: Пополнение баланса">
        <input type="hidden" name="label" value="<?php echo $order['id']; ?>-<?php echo $order['user_id']; ?>">
        <input type="hidden" name="quickpay-form" value="shop">
        <input type="hidden" name="targets"
               value="Пополнение баланса пользователя #<?php echo $order['user_id']; ?> на сумму <?php echo $order['sum']; ?> р.">
        <input type="hidden" name="paymentType" value="<?php echo ($order['system'] == 'AC') ? 'AC' : 'PC'; ?>">
        <input type="hidden" name="sum" value="<?php echo $order['sum']; ?>">
        <?php echo $submit; ?>
    </form>

<?php elseif (isset($system) && $order['system'] == 'wmr') : ?>

<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp"
      accept-charset="windows-1251">
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo $order['sum']; ?>"/>
    <input type="hidden" name="LMI_PAYMENT_DESC"
           value="Пополнение баланса пользователя #<?php echo $order['user_id']; ?> на сумму <?php echo $order['sum']; ?> р."/>
    <input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $order['id']; ?>">
    <input type="hidden" name="LMI_PAYEE_PURSE" value="R384856904150"/>
    <input type="hidden" name="LMI_SIM_MODE" value="0"/>
    <input type="hidden" name="USER_ID" value="<?php echo $order['user_id']; ?>"/>
    <?php echo $submit; ?>
</form>
<?php endif; ?>
