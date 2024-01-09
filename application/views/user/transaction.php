<h4><?=$this->lang->line('make_transaction');?></h4>
<?php if(validation_errors() OR isset($error)) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?><?php echo $error; ?>
</div>
<?php endif; ?>


<?=form_open('user/transaction', 'id="transactionForm"'); ?>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="recipient"><?=$this->lang->line('recipient');?></label>
                <input type="text" class="form-control" name="recipient" value="<?=set_value('recipient');?>" size="50" placeholder="ID" />
            </div>
        </div>     
        <div class="col-lg-2">
            <div class="form-group">
                <label for="sum"><?=$this->lang->line('transaction_sum');?></label>
                <input type="text" class="form-control" name="sum" value="<?=set_value('sum');?>" size="50" placeholder="500" />
            </div>
        </div>    
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-success" value="<?=$this->lang->line('send');?>" />
    </div>
</form>

<hr/>

<h4><?=$this->lang->line('transactions_history');?></h4>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 30px;"></th>
            <th style="width: 180px;"><?=$this->lang->line('sender');?></th>
            <th><?=$this->lang->line('recipient');?></th>
            <th style="width: 180px;"><?=$this->lang->line('sum');?></th>
            <th style="width: 180px;"><?=$this->lang->line('time');?></th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
			<td><?php echo $item->id; ?></td>
            <td align="center">
            <?php 
            if($item->sender == user_id()) {
                echo '<i class="glyphicon-minus" style="color: red; font-weight: bold;"></i>';
            } else {
                echo '<i class="glyphicon-plus" style="color: green; font-weight: bold;"></i>';
            }
            ?>
            </td>
            <td><?php echo $item->sender; ?></td>
			<td><?php echo $item->recipient; ?></td>
			<td><?php echo $item->sum; ?></td>
			<td><?php echo $item->time; ?></td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="6" style="text-align: center;"><?=$this->lang->line('transactions_not_found');?></td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>