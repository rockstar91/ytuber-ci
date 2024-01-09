	<?php if($countries && false) : ?>
	<style>
	.geotarget {}
	.geotarget .panel-heading {cursor: pointer;}
	.geotarget .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		vertical-align: middle;
	}

	</style>
	<div class="panel panel-default geotarget">
	    <div class="panel-heading" onclick="$('.panel-body').toggle();"> <strong><?=$this->lang->line('geo');?></strong></div>
	    <!-- /.panel-heading -->
	    <div class="panel-body">
	        <div class="table-responsive">
	            <table class="table table-striped table-bordered table-hover">
	                <thead>
	                    <tr>
	                        <th><?=$this->lang->line('country');?></th>
	                        <th width="30%"><?=$this->lang->line('state');?></th>
	                        <th width="30%"><?=$this->lang->line('city');?></th>
	                        <th width="42"></th>
	                    </tr>
	                </thead>
	                <tbody>

		                <?php 
		                	$geo = isset($geo) ? $geo : null;
		                	$geo = $this->input->post('geo') ? $this->input->post('geo') : $geo; 
		                ?>

		                <?php if(isset($geo['country']) && is_array($geo['country'])) : ?>
	                	<?php foreach($geo['country'] as $key=>$country_id) : ?>
                		<tr>
                			<td>
                				<input type="hidden" name="geo[country][]" value="<?=$country_id;?>" />
                				<?=$this->Geo->getName($country_id, 'geo_country');?>
                			</td>
                			<td>
                				<?php $region_id = isset($geo['region'][$key]) ? (int) $geo['region'][$key] : 0; ?>
                				<input type="hidden" name="geo[region][]" value="<?=$region_id;?>" />
                				<?=$this->Geo->getName($region_id, 'geo_region');?>
                			</td>
                			<td>
                				<?php $city_id = isset($geo['city'][$key]) ? (int) $geo['city'][$key] : 0; ?>
                				<input type="hidden" name="geo[city][]" value="<?=$city_id;?>" />
                				<?=$this->Geo->getName($geo['city'][$key], 'geo_city');?>
                			</td>
                			<td><a class="btn btn-danger btn-circle geo_del"><i class="glyphicon glyphicon-remove"></i></a></td>
                		</tr>
	                	<?php endforeach; ?>
	                	<?php endif; ?>

	                    <tr id="geo_form">
	                        <td>
								<select class="form-control" name="country_id" id="country_id">
									<option value="0" class="default"><?=$this->lang->line('select_country');?></option>
									<?php foreach ($countries as $country) : ?>
									<option value="<?=$country->id;?>" <?php if($country->iso_2 == $country_code) {echo '';} ?>><?=$country->name;?></option>
									<?php endforeach; ?>
								</select>
	                        </td>
	                        <td>
								<select class="form-control" name="region_id" id="region_id" disabled>
									<option value="0" class="default"><?=$this->lang->line('any_state');?></option>
								</select>
	                        </td>
	                        <td>
								<select class="form-control" name="city_id" id="city_id" disabled>
									<option value="0" class="default"><?=$this->lang->line('any_city');?></option>
								</select>
	                        </td>
	                        <td>
	                        	<a class="btn btn-success btn-circle" id="geo_add"><i class="glyphicon glyphicon-plus"></i></a>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
	        </div>
	        <!-- /.table-responsive -->
	        <p style="font-size: 0.9em;"><?php echo $this->lang->line('geo_tip'); ?></p>
	    </div>
	    <!-- /.panel-body -->
	</div>
	<?php endif; ?>