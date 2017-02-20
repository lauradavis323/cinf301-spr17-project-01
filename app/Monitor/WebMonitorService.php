<?php
namespace App\Monitor\WebMonitorService;

//tries to open a link
//extends abstract class MonitorService
//directly implements abstract method execute()

class WebMonitorService extends MonitorService
{
   private $url;

   public function _construct($n, $f, $i, $u)
   {
      $this->$name = $n;
      $this->$frequency = $f;
      $this->$interval = $i;
      $this->$url = $u;
      $this->$host = 'local host';
   }

   public function execute()
   {
      $fh = @fopen($url, "r");
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
