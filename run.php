 <?php

require 'clases/fetch.php';


try {
	errorlol
	$arg = (isset($argv[1])) ? $argv[1] : "" ;
 	$fetch = new Fetch_Task;
 	$fetch->run($arg);
echo "kka";

} catch (Exception $e) {
	echo $e->getMessage() . PHP_EOL;
	
}
