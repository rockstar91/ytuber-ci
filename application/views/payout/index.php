<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-info-circle fa-1x"></i>
        Приглашая пользователей, вы будете получать 5% от их оплат в рублях, эти деньги можно вывести.    
    </div>
</div>

<div class="row">
    <div class="col-lg-2 col-md-6">
    <h4>Ваш баланс</h4>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo intval($this->user->rub); ?></div>
                        <div>руб.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr/>

<h4>Добавить заявку на вывод</h4>
<?php if(validation_errors()) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>

<?=form_open('payout'); ?>     
    <div class="row">   
        <div class="form-group col-lg-2 col-md-4">
            <label for="system">Система</label>
            <select class="form-control" name="system" id="system">
                <option value="yandex">Яндекс.Деньги</option>
            </select>
        </div>
        <div class="form-group col-lg-2 col-md-4">
            <label for="account">Номер счета</label>
            <input type="text" class="form-control" name="account" value="<?=set_value('account');?>" size="50" placeholder="Номер счета" />
        </div>
        <div class="form-group col-lg-2 col-md-4">
            <label for="rub">Сумма</label>
            <input type="text" class="form-control" name="rub" value="<?=set_value('rub');?>" size="50" placeholder="500" />
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Добавить заявку" />
    </div>
</form>

<hr/>

<h4>История выплат</h4>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 80px;">Система</th>
            <th style="width: 80px;">Номер счета</th>
            <th style="width: 80px;">Сумма</th>
            <th style="width: 180px;">Дата заявки</th>
            <th style="width: 180px;">Дата выплаты</th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
			<td><?php echo $item->id; ?></td>
            <td><?php echo $item->system; ?></td>
            <td><?php echo $item->account; ?></td>
            <td><?php echo $item->rub; ?></td>
            <td><?php echo $item->created; ?></td>
			<td><?php echo $item->payed; ?></td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="6" style="text-align: center;">Выплат нет.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>