<div class="form-group">
	<label>Поисковые системы</label>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[engines][yandex]" value="1">Яндекс</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[engines][google]" value="1">Google</label>
	</div>
</div>

<?php if(false) : ?>
<div class="form-group">
	<label>Социальные сети</label>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][gplus]" value="1">G+</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][yandex]" value="1">Yandex</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][vk]" value="1">Vk</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][facebook]" value="1">facebook</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][twitter]" value="1">twitter</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][odnoklassniki]" value="1">odnoklassniki</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][mailru]" value="1">mail.ru</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][livejournal]" value="1">livejournal</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][blogru]" value="1">blog.ru</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][diaryru]" value="1">diary.ru</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][tumblr]" value="1">tumblr</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][journalru]" value="1">journal.ru</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[socials][wordpress]" value="1">wordpress</label>
	</div>
</div>
<?php endif; ?>

<div class="form-group">
	<label>Устройства</label>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[devices][desktop]" value="1">Десктоп</label>
	</div>
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[devices][mobile]" value="1">Мобильные</label>
	</div>
</div>

<div class="form-group" id="seo_keyword_block">
	<label for="">Ключевые слова</label>
	<p class="small">Одно ключевое слово на строку.</p>
	<?php $keywords = isset($task->extend['keywords']) ? $task->extend['keywords'] : ''; ?>
	<textarea class="form-control" rows="8" name="extend[keywords]"><?=set_value('extend[keywords]', $keywords);?></textarea>
</div>

<div class="form-group" id="links_block">
	<label for="">Внутренние ссылки (или слова)</label>
	<p class="small">Одна ссылка на строку.</p>
	<?php $links = isset($task->extend['links']) ? $task->extend['links'] : ''; ?>
	<textarea class="form-control" rows="8" name="extend[links]"><?=set_value('extend[links]', $links);?></textarea>
</div>


<div class="form-group">
	<div class="checkbox">
	    <label><input type="checkbox" name="extend[pessimization]" value="1">Пессимизация конкурентов</label>
	</div>
</div>