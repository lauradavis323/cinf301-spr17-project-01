<?php
namespace App\Monitor\PortMonitorService;

//checks a service by trying to open a socket to the port
//extends the abstract class: MonitorService
//directly implements the abstract method execute()

class PortMonitorService extends MonitorService
{
   private $port;

   public function _construct($n, $f, $i, $p)
   {
      $this->$name = $n;
      $this->$frequency = $f;
      $this->$interval = $i;
      $this->$port = $p;
      $this->$host = 'local host';
   }

   public function execute()
   {
      $fh = @fsockopen($host, $port, $errno, $errstr, 5);
      if(is_resource($fh))
      {
         fclose($fh);
         return true;
      }
      else
      {
         return false;
      }
   }
}
