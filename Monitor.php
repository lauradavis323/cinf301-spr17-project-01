<?php
//file that runs the program
//does the deamonize stuff
require_once _DIR_ . '/../../vendor/autoload.php';
use App\GeneralUtilities\Utilities as utility;
use App\Monitor\MonitorManager as monitorManager;

$argParse = new utility\ParseArgv();
$files = $argParse->getParsed();

fclose(STDOUT);
//flcose(STDERR);
$STDOUT = fopen($files[o]);
//$STDERR = fopen(

$manager = new monitorManager\MonitorManager();
$children = array();

pcntl_signal(SIGCHLD, function($signo){
   global $children;
   while(($pid = pcntl_wait($status, WNOHANG)) > 0)
   {
      $children = array_diff($children, array($pid));
      if(!pcntl_wifexited($status))
      {
         print("$pid with signo $signo had a problem\n";
      }
   }
}

while(true)
{
   if($manager->runNextMonitor() === "Not Time")
   {
      sleep($manager->getWaitTime());
   }
   else
   {
      $children = $manager->getPid();
   }
}

fclose(STDOUT);
//fclose(STDERR);

$stdout = fopen('/dev/null', 'w');
//$stderr = fopen('php://stdout', 'w');
?>

