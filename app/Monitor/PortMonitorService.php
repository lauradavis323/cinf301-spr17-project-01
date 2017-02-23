<?php
namespace App\Monitor\PortMonitorService;

//checks a service by trying to open a socket to the port
//extends the abstract class: MonitorService
//directly implements the abstract method execute()

class PortMonitorService extends MonitorService
{
   private $port;

   public function __construct($n, $p, $f, $i)
   {
      $this->$name = $n;
      $this->$frequency = $f;
      $this->$interval = $i;
      $this->$port = $p;
      $this->$host = 'local host';
      pcntl_alarm($this->$interval * 60);
   }

   public function execute()
   {
      $fh = @fsockopen($host, $port, $errno, $errstr, 5);
      if(is_resource($fh))
      {
         fclose($fh);
         $this->$status = 'RUNNING';
         return true;
      }
      else
      {
         $this->$status = 'NOT_RESPONDING';
         return false;
      }
   }
}
