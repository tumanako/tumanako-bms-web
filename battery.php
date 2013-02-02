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
$file = '../monitor_linux/src/c/traction2.txt';
$cmd = 'sh -c \'echo -e set xdata time\\\n' . 
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
	'plot ' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:4 title \"Cell 0\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:6 title \"Cell 1\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:8 title \"Cell 2\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:10 title \"Cell 3\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:12 title \"Cell 4\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:14 title \"Cell 5\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:16 title \"Cell 6\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:18 title \"Cell 7\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:20 title \"Cell 8\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:22 title \"Cell 9\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:24 title \"Cell 10\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:26 title \"Cell 11\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:28 title \"Cell 12\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:30 title \"Cell 13\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:32 title \"Cell 14\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:34 title \"Cell 15\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:36 title \"Cell 16\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:38 title \"Cell 17\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:40 title \"Cell 18\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:42 title \"Cell 19\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:44 title \"Cell 20\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:46 title \"Cell 21\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:48 title \"Cell 22\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:50 title \"Cell 23\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:52 title \"Cell 24\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:54 title \"Cell 25\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:56 title \"Cell 26\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:58 title \"Cell 27\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:60 title \"Cell 28\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:62 title \"Cell 29\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:64 title \"Cell 30\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:66 title \"Cell 31\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:68 title \"Cell 32\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:70 title \"Cell 33\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:72 title \"Cell 34\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:74 title \"Cell 35\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:76 title \"Cell 36\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:78 title \"Cell 37\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:80 title \"Cell 38\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:82 title \"Cell 39\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:84 title \"Cell 40\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:86 title \"Cell 41\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:88 title \"Cell 42\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:90 title \"Cell 43\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:92 title \"Cell 44\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:94 title \"Cell 45\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:96 title \"Cell 46\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:98 title \"Cell 47\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:100 title \"Cell 48\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:102 title \"Cell 49\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:104 title \"Cell 50\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:106 title \"Cell 51\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:108 title \"Cell 52\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:110 title \"Cell 53\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:112 title \"Cell 54\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:114 title \"Cell 55\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:116 title \"Cell 56\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:118 title \"Cell 57\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:120 title \"Cell 58\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:122 title \"Cell 59\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:124 title \"Cell 60\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:126 title \"Cell 61\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:128 title \"Cell 62\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:130 title \"Cell 63\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:132 title \"Cell 64\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:134 title \"Cell 65\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:136 title \"Cell 66\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:138 title \"Cell 67\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:140 title \"Cell 68\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:142 title \"Cell 69\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:144 title \"Cell 70\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:146 title \"Cell 71\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:148 title \"Cell 72\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:150 title \"Cell 73\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:152 title \"Cell 74\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:154 title \"Cell 75\"' . $aLines . ',' .
	'\"\\<tail -n ' . $length . ' ' . $file . '\| head -n ' . $count . '\" using 1:\(\( \$4+ \$6+ \$8+ \$10+ \$12+ \$14+ \$16+ \$18+ \$20+ \$22+ \$24+ \$26+ \$28+ \$30+ \$32+ \$34+ \$36+ \$38+ \$40+ \$42+ \$44+ \$46+ \$48+ \$50+ \$52+ \$54+ \$56+ \$58+ \$60+ \$62+ \$64+ \$66+ \$68+ \$70+ \$72+ \$74+ \$76+ \$78+ \$80+ \$82+ \$84+ \$86+ \$88+ \$90+ \$92+ \$94+ \$96+ \$98+ \$100+ \$102+ \$104+ \$106+ \$108+ \$110+ \$112+ \$114+ \$116+ \$118+ \$120+ \$122+ \$124+ \$126+ \$128+ \$130+ \$132+ \$134+ \$136+ \$138+ \$140+ \$142+ \$144+ \$146+ \$148+ \$150+ \$152+ \$154+ 0\)/76\) title \"Average\"' . $bLines .
	'\\\n' .
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
