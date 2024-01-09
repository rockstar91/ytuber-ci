<?php 
$str = '<table class="table table-striped table-bordered table-hover">';
if(isset($result)) {
	foreach($result as $key=>$val) {
		if(is_object($val)) {

			if($key === 0) {
				$str .= '<thead><tr>';
				foreach($val as $ok=>$ov) {
					$str .= "<td>{$ok}</td>";
				}
				$str .= '</tr></thead>';
			}

			$str .= '<tr>';
			foreach($val as $ok=>$ov) {
				if(strpos($ov, 'ggpht.com')) {
					$ov = '<img src="'.$ov.'" alt="" />';
				}
				$str .= "<td>{$ov}</td>";
			}
			$str .= '</tr>';
		}
		else {
			$str .= "<tr><td>{$key}</td><td>{$val}</td></tr>";
		}
	}
}
else {
	$str .= '<tr><td>Нет информации</td></tr>';
}
$str .= '</table>';

echo $str;