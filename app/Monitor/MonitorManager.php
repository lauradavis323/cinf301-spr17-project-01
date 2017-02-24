<?php
namespace App\Monitor;
require_once __DIR__ . '/../../vendor/autoload.php';

//model class
//checks if time for process to spawn child

//objects for PortMonitorService and WebMonitorService
//use reflection

use App\GeneralUtilities as utility;
//use App\Monitor\Service as port;
//use App\Monitor\Service as web;

class MonitorManager
{
   private $Monitors = array();
   private $Timers = array();
   private $files;
   private $pid;

   public function __construct()
   {
      //$argParse = new utility\ParseArgv();
      //$this->$files = $argParse->getParsed();
      $this->createMonitors();
      $this->createTimers();
      $this->sortMonitors();
   }

   private function createMonitors()
   {
      //$reflectedPortMonitor = new \ReflectionClass("App\Monitor\Service\PortMonitorSevice");
      //$reflectedWebMonitor = new \ReflectionClass("web\\WebMonitorService");
      if(file_exists(__DIR__ . 'config.xml'))
      {
         $info = simplexml_load_file(__DIR__ . '/../config.xml');
         foreach($info->services->children() as $service)
         {
            $parts = $service->children();
            if($parts[0] == "PortMonitorService")
            {
               $name = $parts[1]->name;
               $port = $parts[1]->port;
               $frequency = $parts[1]->frequency;
               $interval = $parts[1]->interval;
               //$this->$monitors = $reflectedPortMonitor->newInstanceArgs(array($name, $port, $frequency, $interval));
               $this->$monitors = new App\Monitor\Service\PortMonitorService($name, $port, $frequency, $interval);
            }
            else
            {
               $name = $parts[1]->name;
               $link = $parts[1]->link;
               $frequency = $parts[1]->frequency;
               $interval = $parts[1]->interval;
               //$this->$monitors = $reflectedWebMonitor->newInstanceArgs(array($name, $link, $frequency, $interval));
               $this->$monitors = new App\Monitor\Service\WebMonitorService($name, $link, $frequency, $interval);
            }
         }
      }
      else
      {
         $this->$monitors = new App\Monitor\Service\PortMonitorService('dummy port service', 22, 5, 0.01);
         $this->$monitors = new App\Monitor\Service\WebMonitorService('dummy web service', 'www.google.com', 3, 0.01);
      }
   }
   private function createTimers()
   {
      foreach($monitors as $monitor)
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
      });
   }
   public function runNextMonitor()
   {
      $firstMonitor = $this->$Monitors[0];
      $passed = $this->getTimePassedFirstMonitor() * 60;

      if($passed >= $firstMonitor->getFrequency())
      {
         $this->$pid = pcntl_fork();
         if($this->$pid == 0)
         {
            $firstMonitor->check();
         }
         else
         {
            $this->$timers[$first->getName()] = time();
            $this->sortMonitors();
         }
         return $this->$pid;
      }
      else
      {
         return "Not Time";
      }
   }
   public function getTimePassedFirstMonitor()
   {
      //in seconds
      $currentTime = time();
      $firstMonitor = $this->$Monitors[0];
      $last = $this->$timers[$firstMonitor->getName()];
      return ($currentTime - $last);
   }
   public function getWaitTime()
   {
      $firstMonitor = $this->$monitors[0];
      $frequency = ($firstMonitor->getFrequency)/60;
      $passed = $this->getTimePassedFirstMonitor();
      if($passed < $frequency)
      {
         return $frequency - $passed;
      }
      else
      {
         return 0;
      }
   }
   public function getPid()
   {
      return $this->$pid;
   }
}
?>
