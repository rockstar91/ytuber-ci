<div class="status"></div>
<?php $isAdmin = isset($this->user->admin) ? $this->user->admin : null; ?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?=$this->lang->line('tpl_name');?></th>
            <th style="width: 150px;"><?=$this->lang->line('tpl_type');?></th>
            <th style="width: 150px;"><?=$this->lang->line('tpl_action_cost');?></th>
            <?php if($isAdmin) { ?>
            <th style="width: 100px;"><?=$this->lang->line('tpl_actions');?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
  <?php foreach($results as $item) : ?>
    <tr id="task_<?php echo $item->task_id; ?>">
      <td class="link">
        <a href="#" onclick="YT_TaskClick(<?php echo $item->task_id; ?>, undefined, 1000); return false;"><?php echo $item->name; ?></a>
        <a href=""
      </td>
      <td><?php echo $item->type; ?></td>
      <td>
        <?php echo yt_cost($item->action_cost, 'user'); ?>
      </td>

      <?php if($isAdmin) { ?>
      <td>
      <?php echo anchor('task/remove/'.$item->id, '<i class="glyphicon glyphicon-remove"></i>', 'class="btn btn-danger btn-circle" title="Удалить" onclick="return YT_ConfirmDelete();"'); ?>
      </td>
      <?php } ?>
    </tr>
  <?php endforeach; ?>
  <?php else : ?>
    <tr><td colspan="5" style="text-align: center;"><?=$this->lang->line('tpl_no_task');?></td></tr>
  <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>