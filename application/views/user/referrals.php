<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $this->lang->line('main_info'); ?></div>
            <div class="panel-body">
                <div class="form-group">
                    <label><?php echo $this->lang->line('your_ref_link'); ?></label>
                    <input type="text" class="form-control" name="url" value="<?php echo site_url((int)$this->user->id);?>" onclick="this.select();" />
                    <p class="help-block"><?php echo $this->lang->line('ref_link_tip'); ?></p>
                </div>

                <label><?php echo $this->lang->line('statistics'); ?></label>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><?php echo $this->lang->line('total_referrals'); ?></td>
                                <td><?=$total_refferals;?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('total_act_referrals'); ?></td>
                                <td><?=$total_act;?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('earned_for_you'); ?></td>
                                <td><?=$total_earned;?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p style="font-size: 0.9em;"><?php echo $this->lang->line('main_tip'); ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">Top 5</div>
            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th style="width: 120px;"><?php echo $this->lang->line('earned'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($top) : ?> 
                            <?php foreach($top as $item) : ?>
                            <tr>
                                <td><?=$item->id;?></td>
                                <td><?=htmlspecialchars($item->name);?></td>
                                <td><?=$item->earned;?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                             <tr><td colspan="3" style="text-align: center;"><?php echo $this->lang->line('no_referrals'); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<?php $isAdmin = isset($this->user->admin) ? $this->user->admin : null; ?>

<h4><?php echo $this->lang->line('referral_list'); ?></h4>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 180px;"><?php echo $this->lang->line('registration_date'); ?></th>
            <th><?php echo $this->lang->line('name'); ?></th>
            <?php if($isAdmin) {echo '<th>E-mail</th>';} ?>
            <?php if($isAdmin) {echo '<th>Confirm</th>';} ?>
            <th style="width: 180px;"><?php echo $this->lang->line('complete_task'); ?></th>
            <th style="width: 180px;"><?php echo $this->lang->line('earned'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
			<td><?php echo $item->id; ?></td>
			<td><?php echo $item->time; ?></td>
			<td><?php echo htmlspecialchars($item->name); ?></td>
            <?php if($isAdmin) {echo '<td>'.$item->mail.'</td>';} ?>
            <?php if($isAdmin) {echo '<td>'.$item->confirm.'</td>';} ?>
			<td><?php echo $item->done; ?></td>
			<td><?php echo $item->earned; ?></td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="<?php echo $isAdmin ? 7 : 5; ?>" style="text-align: center;"><?php echo $this->lang->line('no_referrals'); ?></td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>