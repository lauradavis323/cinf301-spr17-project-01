<?php

//model class
//checks if time for process to spawn child

//objects for PortMonitorService and WebMonitorService
//use reflection

//handles child closing
pcntl_signal(SIGCHLD, function($signo){
});

//fork and do stuff
?>
