<?php
namespace App\GeneralUtilities\Utilities
//copied from homework 3:
//Change as needed
//figure out what changes are needed

//command line arguments for project 1 include:
// -c configfile -o outfile
class Utilities.php
{
   private $argsParsed;
   private $argsUnparsed;

   public function __construct()
   {
      $this->$argsUnparsed = $_SERVER['argv'];
      $this->$argsParsed = array();
      $this->parse();
   }

   public function getParsed()
   {
      return $this->argsParsed;
   }

   private function parse()
   {
      $key = '0';
      $content = 'true';
      if($a[0] == '-')
      {
         $key = '0';
         $content = 'true';
         if($a[1] == '-')
         {
            $pos = strpos($a, '=');
            $key = substr($a, 2, $pos -1);
            $content = substr($a, $pos +1);
            $argsParsed[$key] = $content;
         }
         else
         {
            $key = substr($a, 1);
            $argsParsed[$key] = $content;
         }
      }
      else
      {
         if($key === '0')
         {
            $content = $a;
            $argsParsed[$key] = $content;
         }
      }
   }
}
