<?php
namespace App\Monitor\MonitorManager
require_once _DIR_ . '/../../vendor/autoload.php';

//model class
//checks if time for process to spawn child

//objects for PortMonitorService and WebMonitorService
//use reflection

use App\GeneralUtilities\Utilities as utility;
use App\Monitor\PortMonitorService as port;
use App\Monitor\WebMonitorService as web;

class MonitorManager
{
   private $Monitors = array();
   private $Timers = array();
   private $files;

   public function __construct()
   {
      $argParse = new utility\ParseArgv();
      $this->$files = $argParse->getParsed();
      createMonitors($files[c]);
      createTimers();
      sortMonitors();
   }

   private function createMonitors($file)
   {
      $info = simplexml_load_file($file);
      $reflectedPortMonitor = new ReflectionClass("port\PortMonitorSevice");
      $reflectedWebMonitor = new ReflectionClass("web\WebMonitorService");
      foreach($info->services->children() as $service)
      {
         $parts = $service->children();
         if($parts[0] == "PortMonitorService")
         {
            $name = $parts[1]->name;
            $port = $parts[1]->port;
            $frequency = $parts[1]->frequency;
            $interval = $parts[1]->interval;
            $this->$monitors = $reflectedPortMonitor->newInstanceArgs(array($name, $port, $frequency, $interval));
         }
         else
         {
            $name = $parts[1]->name;
            $link = $parts[1]->link;
            $frequency = $parts[1]->frequency;
            $interval = $parts[1]->interval;
            $this->$monitors = $reflectedWebMonitor->newInstanceArgs(array($name, $link, $frequency, $interval));
         }
      }
   }
   private function createTimers()
   {
      foreach($monitors as $monitor){
      {
         $this->$timers[$monitor->getName()] = time();
      }
   }
   public function sortMonitors()
   {
      usort($this->$monitors, function ($a, $b){
         global $timers;
         $currentTime = time();
         $aLast = $timers[$a->getName()];
         $bLast = $timers[$b->getName()];
         $aSince = $currentTime - $aLast;
         $bSince = $currentTime - $bLast;
         $aUntil = ($a->getFrequency()) - ($aSince * 60);
         $bUntil = ($b->getFrequency()) - ($bSince * 60);
         if($aUntil == $bUnitl)
         {
            return 0;
         }
         else if($aUntil < $bUntil)
         {
            return -1;
         }
         else
         {
            return 1;
         }
      }
   }
   public function runNextMonitor()
   {
   }
}
?>
