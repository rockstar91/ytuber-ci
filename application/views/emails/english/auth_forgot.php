<p>Hello!</p>

<p>Someone, possibly you, is trying to reset your account password.</p>

<p>Your login: <?=$mail;?><br/>
If you sure want to reset your password, please click here.: <?=site_url('auth/reset/'.$id.'/'.$forgot_token);?>
</p>

<p>If you didn’t do anything to get this information, just ignore this email.</p>