<?php
include "locks.php";

takeLock("accessory");

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

#	'set yrange [3300:3700]\\\n' .
$file = '../monitor_linux/src/c/accessory.txt';
$cmd = 'sh -c \'echo -e \\\n' .
	'set xdata time\\\n' . 
	'set timefmt \"%s\"\\\n' .
	'set key left top\\\n' .
	'set nokey\\\n' .
	'set grid\\\n' .
	'set ylabel \"V\"\\\n' .
	'set y2label \"V\"\\\n' .
#	'set yrange [3:3.7]\\\n' .
	'set ytics nomirror\\\n' .
	'set y2tics border\\\n' .
	'set x2zeroaxis lt -1\\\n' .
	'set terminal png size 1200,300\\\n' .
	'plot ';
for ($i = 0; $i < 4; $i++) {
	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:' . ($i * 3 + 10) . ' title \"Cell ' . $i . '\" with lines,';
}
$cmd = substr($cmd, 0, -1);
$cmd = $cmd . '\\\n' .
	'\'| gnuplot';

if (isset($_GET["s"])) {
	header('Content-type: text/plain');
	print($cmd);
} else {
	header('Content-type: image/png');
	passthru($cmd);
}
releaseLock("accessory");
?>
