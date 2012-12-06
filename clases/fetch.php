 <?php

 /**
 * 
 */
 class Asset 
 {
 	
 	function fetch($assetPath)
 	{
 		return file_get_contents($assetPath);
 	}
 }

 /**
  * undocumented class
  *
  * @package default
  * @author 
  **/
 class  Fetch_Task
 {
 	public static $cssDirectory = 'css/vendors/';
 	public static $jsDirectory = 'js/vendors/';

 	public static $paths = array(
 		'jquery' => 'http://code.jquery.com/jquery.js',
 		'normalize' => 'http://necolas.github.com/normalize.css/2.0.1/normalize.css',
 		'backbone' => 'http://backbonejs.org/backbone.js',
 		'underscore' => 'http://underscorejs.org/underscore.js',
 		'equital' => 'https://ws.equital.com.uy/webcablews/servlet/awsctting?wsdl'
 		);

 	public function __construct(Asset $file = null)
 	{
 		if (!is_null($file))
 		{
 			$this->file = $file;
 		}
 		else
 			$this->file = new Asset;
 	}

 	public function run($query = null)
 	{
 		if (!$query) {
 			throw new InvalidArgumentException("Debe pasar el nombre del asset", 1);
 			
 		}

 		$this->asset = strtolower($query);

 		// si el asset esta en el array descargarlo y guardarlo
 		if ($this->reconoceAsset($this->asset))
 		{
 			$this->fetch(static::$paths[$this->asset]);
 		} else {
 			echo "Asset {$this->asset} desconocido" . PHP_EOL;
 		}
 	}

 	public function reconoceAsset($asset)
 	{
 		return array_key_exists($asset, static::$paths);
 	}

 	public function fetch($assetPath)
 	{
 		$content = $this->file->fetch($assetPath);
 		$this->crearArchivo($this->asset, $content);
 		echo "Descarga completa" . PHP_EOL;
 	}

 	public function crearArchivo($asset, $content)
 	{
 		$file = pathinfo(static::$paths[$asset]);

 		switch ($file['extension']) {
 			case 'js':
 				$path = static::$jsDirectory.$file['basename'];
 				break;
 			case 'css':
 			default:
 				$path = static::$cssDirectory.$file['basename'];
 				break;
 		}

 		Archivo::crear($path,$content);
 	}


 } // END class  Fetch


 /**
 * 
 */
 class Archivo
 {
 	

 	public function crear($path, $content)
 	{
 		$ourFileHandle = fopen($path, 'x', true) or die("can't open file");
		fwrite($ourFileHandle, $content);
		fclose($ourFileHandle);
 	}
 }
