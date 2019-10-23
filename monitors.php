<?php

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Divide screen function.
 **/
function divide_screen($unify = FALSE) {
  $command = "xrandr ";
  $output = shell_exec('xrandr --listactivemonitors');
  $monitors = explode(PHP_EOL, $output);
  array_shift($monitors);
  $monitors = array_filter($monitors);
  $initial_resolution = 0;
  foreach ($monitors as $monitor) {
    $pieces = explode(' ', $monitor);
    $monitor_name =  str_replace(array("\r", "\n"), '', array_pop($pieces));
    $command .= "--output " . $monitor_name . " --mode 1920x1080 --pos " . $initial_resolution . "x0 --rotate normal ";
    $initial_resolution += $unify ? 0 : 1920;
  }
  return $command;

}

$unify = in_array('unify', $argv);
$command = divide_screen($unify);
if (in_array('help', $argv)) {
  print "divide_screen [unify]\r\n";
  print($command . "\r\n");
} else {
  print($command . "\r\n");
  shell_exec($command);
}
