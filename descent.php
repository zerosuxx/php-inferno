<?php

echo "\033[31m";
?>
Abandon hope, all ye who enter here...

.########.##.....##.########....####.##....##.########.########.########..##....##..#######.
....##....##.....##.##...........##..###...##.##.......##.......##.....##.###...##.##.....##
....##....##.....##.##...........##..####..##.##.......##.......##.....##.####..##.##.....##
....##....#########.######.......##..##.##.##.######...######...########..##.##.##.##.....##
....##....##.....##.##...........##..##..####.##.......##.......##...##...##..####.##.....##
....##....##.....##.##...........##..##...###.##.......##.......##....##..##...###.##.....##
....##....##.....##.########....####.##....##.##.......########.##.....##.##....##..#######.

<?php
echo "\033[0m";
#PHP Deprecated:  Methods with the same name as their class will not be constructors in a future version of PHP; ClassWithNameAsConstructor has a deprecated constructor
#PHP Warning/Notice:  A non-numeric value encountered in /home/travis/build/zerosuxx/php-inferno/trials/Heresy.php on line 38
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING ^ E_NOTICE);

$min_version = '5.4.9';
if (version_compare($min_version, phpversion()) > 0)
{
	trigger_error("You must have PHP $min_version or greater installed to enter the Inferno. Check the README for instructions.", E_USER_ERROR);
}

require_once 'Pathway_Through_Darkness.php';

$pathway = new Pathway_Through_Darkness(array(
	'Limbo',
	'Lust',
	'Gluttony',
	'Greed',
	'Anger',
	'Heresy',
	'Violence',
	'Fraud',
	'Treachery'
));

if ($argc > 1)
{
	$exercise = explode(':', $argv[1]);
	$pathway->descend_match($exercise[0], $exercise[1]);
}
else
{
	$pathway->descend();
}
