<?php
function takeLock($id)
{
  $lockFile = "/tmp/lock_$id";
  if ($fp = @fopen($lockFile, "w")) {
   flock($fp,LOCK_EX);
  }
} 

function releaseLock($id) {
  $lockFile = "/tmp/lock_$id";
  if ($fp = @fopen($lockFile, "w")) {
   flock($fp,LOCK_UN);
  }
}
?>
