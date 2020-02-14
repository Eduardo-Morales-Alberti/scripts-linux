<?php

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Divide screen function.
 **/
function divide_screen($unify = FALSE, $left_postion = TRUE) {
  $config_file = @file_get_contents(dirname(__FILE__). "/config_monitor.json");

  $monitors = json_decode($config_file, TRUE);
  if (empty($monitors)) {
      $monitors = get_monitors_weights();
  }
  $command = "xrandr ";

  $initial_resolution = 0;

    // If unify, not necessary rearrange the monitors.
    // If initial resolution and main screen right, get first element to the final.
    if (!$unify && $initial_resolution == 0 && !$left_postion) {
        $main = array_shift($monitors);
        $monitors[] = $main;
    }
  foreach ($monitors as $key => $monitor) {

      print($monitor . PHP_EOL);
      $command .= "--output " . $monitor . " --mode 1920x1080 --pos " . $initial_resolution . "x0 --rotate normal ";
      $initial_resolution += $unify ? 0 : 1920;

  }
  return $command;

}

/**
 * Set monitors weights.
 */
function get_monitors_weights($save_file = TRUE) {
    $output = shell_exec('xrandr --listactivemonitors');
    $monitors = explode(PHP_EOL, $output);
    array_shift($monitors);
    $monitors = array_filter($monitors);

    $monitors = array_map(function ($value) {
        $pieces = explode(' ', $value);
        return str_replace(array("\r", "\n"), '', array_pop($pieces));
    }, $monitors);
    if ($save_file) {
        print "There are the following monitors:" . PHP_EOL;
        print_r($monitors);
        $count = (count($monitors) - 1);
        print "Set the weight by monitor with a number, from 0 to " . $count . ", please do not repeat numbers." . PHP_EOL;
        $values = range(0, $count);
        foreach ($monitors as $monitor) {
            do {
                $value = readline("Set the weight for " . $monitor . ' monitor: ');
                print($value);
            } while (!is_numeric($value) || !in_array($value, $values));
            $key = array_search($value, $values);
            unset($values[$key]);
            $monitors_weight[$value] = $monitor;
        }

        ksort($monitors_weight);

        $config_file = fopen(dirname(__FILE__). "/config_monitor.json", "w") or die("Unable to open file!");
        fwrite($config_file, json_encode($monitors_weight, JSON_PRETTY_PRINT));
        fclose($config_file);
        $monitors = $monitors_weight;
    }

    print_r($monitors);
    return $monitors;
}

// -u To unify screens
$unify = in_array('-u', $argv);
// -d To divide screens.
$divide = in_array('-d', $argv);
// Left position main monitor, -r to right position.
$left_position = in_array('-r', $argv) ? FALSE : TRUE;
if ($divide || $unify) {
   $command = divide_screen($unify, $left_position);
}
// Set weight positions monitors.
$set_weight = in_array('-s', $argv);
if ($set_weight) {
    get_monitors_weights();
}

if (in_array('-h', $argv)) {
  print "monitor.php -u ** To unify screens. By default main monitor to left, -r main monitor to right.\r\n";
  print "monitor.php -d ** To divide screens.\r\n";
  print "monitor.php -s ** Set weight positions monitors.\r\n";
} elseif (!empty($command)) {
  print($command . "\r\n");
  shell_exec($command);
}
