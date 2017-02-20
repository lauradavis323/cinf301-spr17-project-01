<?php
namespace App\Monitor\MonitorService;

//abstract class
//abstract method: execute()
//implements everything that needs to be done
//to monitor a service except
//opening the port or webpage
//that is done by the implementing class

abstract class MonitorService
{
   private $name;
   private $frequency;
   private $interval;
   //interval and frequency are time in minutes
   private $status;//RUNNING or NOT_RESPONDING
   private $attemptNum;//1,2,3
   private $attemptState;//INFO or WARNING or CRITICAL
   private $host;

   abstract protected function execute();

   public function check()
   {
      $this->$attemptNum = 1;
      if(execute())
      {
         //1st
         //exit using SIGCHLD with anonymous class
         //status logged as INFO
         //comment that service was running properly
         //not in that order!
         $this->$attemptState = 'INFO';
         exit;
      }
      else
      {
         //status logged as WARNING
         $this->$attemptState = 'WARNING';
      }
      //sleep for interval
      //wake with SIGALRM
      //increment attemptNum
      sleep($this->$interval * 60);
      $this->$attemptNum = 2;
      if(execute())
      {
         //2nd
         //INFO status logged
         //exit
         $this->$attemptState = 'INFO';
         exit;
      }
      else
      {
         //status logged as WARNING
         $this->$attemptState = 'WARNING';
      }
      //sleep for interval
      //wake with SIGALRM
      //increment attemptNUM
      sleep($this->$interval * 60);
      $this->$attemptNum = 3;
      if(execute())
      {
         //3rd
         //INFO status logged
         //exit
         $this->$attemptState = 'INFO';
         exit;
      }
      else
      {
         //status logged as CRITICAL
         //exit
         $this->$attemptState = 'CRITICAL';
         exit;
      }
   }

   public function getAttemptStatus()
   {
      return $this->$attemptState;
   }
}
