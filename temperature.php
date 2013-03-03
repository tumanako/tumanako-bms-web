<?php
include "locks.php";

takeLock("temperature");

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
$cmd = 'sh -c \'echo -e \\\n' .
	'set xdata time\\\n' . 
	'set timefmt \"%s\"\\\n' .
	'set key left top\\\n' .
	#'set nokey\\\n' .
	'set grid\\\n' .
	'set ylabel \"C\"\\\n' .
	'set y2label \"km/h\"\\\n' .
	#'set y2range [-3:0]\\\n' .
	'set ytics nomirror\\\n' .
	'set y2tics border\\\n' .
	'set x2zeroaxis lt -1\\\n' .
	'set terminal png size 1200,300\\\n' .
	'plot ';
	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:7 title \"T1\" with lines,';
	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:8 title \"T2\" with lines,';
#	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:9 title \"Speed\" axis x1y2 with lines,';
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
releaseLock("temperature");
?>
