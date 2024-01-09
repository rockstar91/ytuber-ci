<?php 
echo "Ссылка для подтвержения email: ".site_url('auth/confirm/?id='.$id.'&code='.$confirm);