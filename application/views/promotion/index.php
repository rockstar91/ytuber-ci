<?php if(validation_errors()) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
            	<i class="fa fa-info-circle fa-1x"></i>
               	Как привлечь рефералов
            </div>
            <div class="panel-body">
				<p>Приглашайте друзей, родственников и знакомых &mdash; перейдя по вашей реферальной ссылке и зарегистрировавшись на сайте, пользователь автоматически становится вашим рефералом.</p>
				<p>Делитесь вашей реферальной ссылкой в тематических группах в соц. сетях, форумах, блогах.</p>
            </div>
        </div>
	</div>
</div>

<div class="row">
    
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<i class="fa fa-youtube"></i>
                Запишите видео о YTuber
            </div>
            <div class="panel-body">
            	<label>Что нужно сделать:</label>
            	<p>Запишите видео о YTuber, опубликуйте его на YouTube и пришлите нам ссылку на видео.</p>
            	<label>Условия:</label>
				<ul>
				<li>Ваше видео должно быть оригинальным.</li>
				<li>Видео должно быть длинее 1 минуты.</li>
				<li>Видео должно содержать вашу реферальную ссылку на YTuber.ru в описании.</li>
				<li>Видео должно быть хорошего качества.</li>
				</ul>
            	<label>Вознаграждение:</label>
            	<p>250 баллов</p>
            </div>
            <div class="panel-footer">
				<?=form_open('promotion'); ?>
				    <div class="form-group">
				        <input type="hidden" name="type" value="youtube" />
				        <input class="form-control" name="link" placeholder="Ссылка на видео" />
				    </div>
				    <div class="form-group">
				   		<button type="submit" class="btn btn-default">Отправить</button>
				    </div>
				</form>
            </div>
        </div>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
            	<i class="fa fa-share-square fa-1x"></i>
            	Создайте пост о YTuber
            </div>
            <div class="panel-body">
            	<label>Что нужно сделать:</label>
            	<p>Создайте тему о YTuber на форуме или пост в блоге и пришлите нам ссылку.</p>
            	<label>Условия:</label>
				<ul>
				<li>Пост должен соответствовать правилам выбраного форума или блога.</li>
				<li>Ваше сообщение должно содержать реферную ссылку на YTuber.</li>
				</ul>
            	<label>Вознаграждение:</label>
            	<p>150 баллов</p>
            </div>
            <div class="panel-footer">
				<?=form_open('promotion'); ?>
				    <div class="form-group">
				        <input type="hidden" name="type" value="forum" />
				        <input class="form-control" name="link" placeholder="Ссылка на тему" />
				    </div>
				    <div class="form-group">
				   		<button type="submit" class="btn btn-default">Отправить</button>
				    </div>
				</form>
            </div>
        </div>
    </div>
</div>