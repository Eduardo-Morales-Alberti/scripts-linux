<?php

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

// Definir el orden de los monitores, si hay un nuevo monitor, volver a pedir el orden, guardar el orden en un fichero json.
// Añadir left o right según esté el portatil.
// Definir cual es el monitor del portatil.

/**
 * Divide screen function.
 **/
function divide_screen($unify = FALSE, $left_postion = TRUE) {
  $configuration_file = json_encode([
    'main' => 'eDP-1',
    0 => 'HDMI-2',
    1 => 'HDMI-1',
  ]);

  $monitors = json_decode($configuration_file, TRUE);

  $command = "xrandr ";

//  $output = shell_exec('xrandr --listactivemonitors');
//  $monitors = explode(PHP_EOL, $output);
//  array_shift($monitors);
//  $monitors = array_filter($monitors);
//
//    $monitors = array_map(function ($value) {
//        $pieces = explode(' ', $value);
//        return str_replace(array("\r", "\n"), '', array_pop($pieces));
//    }, $monitors);

  $initial_resolution = 0;

  foreach ($monitors as $key => $monitor) {
      if (!$unify && $initial_resolution == 0 && $left_postion && isset($monitors['main'])) {
          print("Melon");
          $monitor = $monitors['main'];
      }
      elseif (!$unify && !$left_postion && isset($monitors['main']) && count($monitors) == ($key - 1)) {
          print("Melon2");
          $monitor = $monitors['main'];
      }
      print($monitor . PHP_EOL);

      $command .= "--output " . $monitor . " --mode 1920x1080 --pos " . $initial_resolution . "x0 --rotate normal ";
      $initial_resolution += $unify ? 0 : 1920;

  }
  return $command;

}

$unify = in_array('unify', $argv);
$left_position = in_array('right', $argv) ? FALSE : TRUE;
$command = divide_screen($unify, $left_position);
if (in_array('help', $argv)) {
  print "divide_screen [unify]\r\n";
  print($command . "\r\n");
} else {
  print($command . "\r\n");
  exit();
  shell_exec($command);
}
