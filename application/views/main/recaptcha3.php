<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>



<script>
//grecaptcha.ready(function() {
	//grecaptcha.execute('6Lf68XcUAAAAAIn8ehzK5NEA4RVXFeVMnzJAx-ZO', {action: 'homepage'})
	//.then(function(token) {
	// Verify the token on the server.
	//});
//});


function submitForm() {
    document.getElementById("loginForm").submit();
}
</script>

<?php echo form_open('main/recaptcha3', 'class="login-form" id="loginForm"'); ?>
	<div class="row">
		<input id="email" name="mail" class="form-control" type="email" placeholder="<?php echo $this->lang->line('email'); ?>"/>
	</div>

	<div class="row">
		<input id="password" name="password" class="form-control" type="password" placeholder="<?php echo $this->lang->line('password'); ?>"/>
	</div>
	
	<div class="row">							
		<div class="col-lg-12 legend" style="padding: 0;">
		<button type="submit" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>" data-callback="submitForm" class="g-recaptcha btn1 btn-7 btn-7a"><?php echo $this->lang->line('login_btn'); ?></button>
		</div>
	</div>
</form>

<script>


/*
$(document).ready(function(){

	$('form').submit(function(e) { 
        // we stoped it
        e.preventDefault();
        // needs for recaptacha ready
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute('6Lf68XcUAAAAAIn8ehzK5NEA4RVXFeVMnzJAx-ZO', {action: 'loginForm'}).then(function(token) {
                // add token to form
                $('form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                // submit form now
                $('form').unbind('submit').submit();
            });;
        });
    });	
});
*/
</script>
</body>
</html>