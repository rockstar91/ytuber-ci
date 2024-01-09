<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Ожидайте...</title>
    <?php require_once(dirname(__FILE__) . '/../_head.php'); ?>
    <?php if (false) : ?>
        <script>
            var canPlay = false;
            var v = document.createElement('video');
            if (v.canPlayType && v.canPlayType('video/mp4').replace(/no/, '')) {
                canPlay = true;
            }
            if (canPlay && 'Notification' in window) {
                setTimeout('location="<?php echo $href; ?>";', 1000);
                console.log('can play');
            } else {
				
				console.log('can\'t play');
            }
            
        </script>
    <?php endif; ?>
</head>
<iframe src="javascript:parent.location='<?php echo $href; ?>'" style="visibility:hidden">
</iframe>
<script>
    var x = 0;
    var canPlay = false;
    var v = document.createElement('video');
    if (v.canPlayType && v.canPlayType('video/mp4').replace(/no/, '')) {
        canPlay = true;
    }
    if (canPlay && 'Notification' in window) {
        window.setTimeout('go()', 1000);
        console.log('can play');
    } else {

		console.log('can\'t play');
    }

    function go() {
        location.replace("<?php echo $href; ?>");
    }


</script>
</body>
</html>