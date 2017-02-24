<?php
//file that runs the program
//does the deamonize stuff
require_once __DIR__ . '/vendor/autoload.php';
use App\GeneralUtilities as utility;
use App\Monitor as monitorManager;

//$argParse = new utility\Utility();
//$files = $argParse->getParsed();

//fclose(STDOUT);
//flcose(STDERR);
//$STDOUT = fopen('/./out.log', 'wb');
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
         print("$pid with signo $signo had a problem\n");
      }
   }
});

$i = 0;
while($i < 3)
{
   if($manager->runNextMonitor() === "Not Time")
   {
      sleep($manager->getWaitTime());
   }
   else
   {
      $children = $manager->getPid();
   }
   $i = $i + 1;
}

//fclose(STDOUT);
//fclose(STDERR);

//$stdout = fopen('/dev/null', 'w');
//$stderr = fopen('php://stdout', 'w');
?>

