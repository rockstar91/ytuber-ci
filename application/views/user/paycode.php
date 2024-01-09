<?php if(validation_errors()) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>

<?=form_open('user/paycode'); ?>
    <div class="form-group">
        <label for="paycode">Код</label>
        <input type="text" class="form-control" name="paycode" value="<?=set_value('paycode');?>" size="50" placeholder="Уникальный код" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Зачислить" />
    </div>
</form>