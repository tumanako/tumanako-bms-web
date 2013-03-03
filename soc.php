<?php
include "locks.php";

takeLock("soc");

$length = isset($_GET["l"]) ? $_GET["l"] : '';
$count = isset($_GET["c"]) ? $_GET["c"] : '';
if ($length == '') {
	$length = 40;
}
if ($count == '') {
	$count = 10000;
}
$length = intval($length);
$count = intval($count);

$file = '../monitor_linux/src/c/traction3.txt';
$cmd = 'sh -c \'echo -e \\\n' .
	'set xdata time\\\n' . 
	'set timefmt \"%s\"\\\n' .
	'set terminal png size 1200,300\\\n' .
	'set tics nomirror\\\n' .
	'set y2tics border\\\n' .
	'set ylabel \"A\"\\\n' .
	'set y2label \"Ah\"\\\n' .
#	'set y2range [0,2]\\\n' .
#	'set ticscale 0 0\\\n' .
#	'set grid xtics y2tics\\\n' .
	'set key left top\\\n' .
	'set grid\\\n' .
	'set y2zeroaxis lt -1\\\n' .
	'set yzeroaxis lt -1\\\n' .
	'set xzeroaxis lt -1\\\n' .
	'plot ' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:2 title \"Current\" axis x1y1,' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using  1:\(\$3\) title \"Ah\" axis x1y2' . 
	'\\\n' .
	'\'| gnuplot';

if (isset($_GET["s"])) {
	header('Content-type: text/plain');
	print($cmd);
} else {
	header('Content-type: image/png');
	passthru($cmd);
}
releaseLock("soc");
?>
