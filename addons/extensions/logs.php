<?php


function WriteLog(string $message) : void{
    $logFile = fopen(__DIR__."/../../logs/logs.txt", "a+");
    if(!$logFile){
      return;
    }
    fwrite($logFile, $message . "\n");
    fclose($logFile);
}