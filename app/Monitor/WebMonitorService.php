<?php
namespace App\Monitor\WebMonitorService;

//tries to open a link
//extends abstract class MonitorService
//directly implements abstract method execute()

class WebMonitorService extends MonitorService
{
   private $url;

   public function __construct($n, $u, $f, $i)
   {
      $this->$name = $n;
      $this->$frequency = $f;
      $this->$interval = $i;
      $this->$url = $u;
      $this->$host = 'local host';
      pcntl_alarm($this->$interval * 60);
   }

   public function execute()
   {
      $fh = @fopen($url, "r");
      if(is_resource($fh))
      {
         fclose($fh);
         $this->$status = 'RUNNING';
         return true;
      }
      else
      {
         $this->$status = 'NOT_RESPONDING'
         return false;
      }
   }
}
