for pid in `ps aux | grep 'php consumer.php' | awk '{print $2}'` ; do
  kill -9 $pid
done
