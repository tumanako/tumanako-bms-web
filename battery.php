<?php
include "locks.php";

takeLock("battery");

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

$aLines = " with lines";
$bLines = "";
#	'set yrange [3300:3700]\\\n' .
$file = '../monitor_linux/src/c/traction3.txt';
$cmd = 'sh -c \'echo -e \\\n' .
	'set xdata time\\\n' . 
	'set timefmt \"%s\"\\\n' .
	'set key left top\\\n' .
	'set nokey\\\n' .
	'set grid\\\n' .
	'set ylabel \"V\"\\\n' .
	'set y2label \"V\"\\\n' .
	#'set y2range [-3:0]\\\n' .
	'set ytics nomirror\\\n' .
	'set y2tics border\\\n' .
	'set x2zeroaxis lt -1\\\n' .
	'set terminal png size 1200,300\\\n' .
	'plot ';
for ($i = 0; $i < 76; $i++) {
	$cmd = $cmd . '\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:' . ($i * 3 + 10) . ' title \"Cell ' . $i . '\"' . $aLines . ',';
}
$cmd = substr($cmd, 0, -1);
$cmd = $cmd . '\\\n' .
	'\'| gnuplot';
	

	#'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:\(\( \$4+ \$6+ \$8+ \$10+ \$12+ \$14+ \$16+ \$18+ \$20+ \$22+ \$24+ \$26+ \$28+ \$30+ \$32+ \$34+ \$36+ \$38+ \$40+ \$42+ \$44+ \$46+ \$48+ \$50+ \$52+ \$54+ \$56+ \$58+ \$60+ \$62+ \$64+ \$66+ \$68+ \$70+ \$72+ \$74+ \$76+ \$78+ \$80+ \$82+ \$84+ \$86+ \$88+ \$90+ \$92+ \$94+ \$96+ \$98+ \$100+ \$102+ \$104+ \$106+ \$108+ \$110+ \$112+ \$114+ \$116+ \$118+ \$120+ \$122+ \$124+ \$126+ \$128+ \$130+ \$132+ \$134+ \$136+ \$138+ \$140+ \$142+ \$144+ \$146+ \$148+ \$150+ \$152+ \$154+ 0\)/76\) title \"Average\"' . $bLines .

if (isset($_GET["s"])) {
	header('Content-type: text/plain');
	print($cmd);
} else {
	header('Content-type: image/png');
	passthru($cmd);
}
releaseLock("battery");
?>
