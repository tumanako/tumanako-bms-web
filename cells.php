<?php
include "locks.php";

takeLock("cells");

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

$cellParam = isset($_GET["cells"]) ? $_GET["cells"] : '';
$cells = explode(",", $cellParam);

#	'set yrange [3300:3700]\\\n' .
$file = '../monitor_linux/src/c/traction3.txt';
$cmd = 'sh -c \'echo -e set xdata time\\\n' . 
	'set timefmt \"%s\"\\\n' .
	'set key left top\\\n' .
	#'set nokey\\\n' .
	'set grid\\\n' .
	'set ylabel \"V\"\\\n' .
	'set y2label \"V\"\\\n' .
	#'set y2range [-3:0]\\\n' .
	'set ytics nomirror\\\n' .
	'set y2tics border\\\n' .
	'set x2zeroaxis lt -1\\\n' .
	'set terminal png size 1200,300\\\n' .
	'plot ';
$i = 0;
foreach ($cells as $cell) {
	$cell = intval($cell);
	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:' . ($cell * 3 + 10) . ' title \"Cell ' . $cell . '\" with lines,';
	$i = $i + 1;
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
releaseLock("battery");
?>
