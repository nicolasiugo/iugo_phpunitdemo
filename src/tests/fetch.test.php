 <?php

 require '../clases/fetch.php';

 class Fetch_Test extends PHPUnit_Framework_TestCase
 {
 	public static $cssDirectory = 'css/vendors/';
 	public static $jsDirectory = 'js/vendors/';

 	public function setUp()
 	{
 		$stub = $this->getMock('Asset');
 		$stub->expects($this->any())
 			 ->method('fetch')
 			 ->will($this->returnValue("contenido de prueba"));
 		$this->fetch = new Fetch_Task($stub);
 	}

 	public function tearDown()
 	{
 		if (file_exists(static::$jsDirectory.'jquery.js')) {
 			unlink(static::$jsDirectory.'jquery.js');
 		}
 		if (file_exists(static::$cssDirectory.'normalize.css')) {
 			unlink(static::$cssDirectory.'normalize.css');
 		}
 	}

 	public function testsSeGuardaListaDeAssets($value='')
 	{
 		$this->assertClassHasStaticAttribute('paths', 'Fetch_Task');
 		$this->assertArrayHasKey('jquery', Fetch_Task::$paths);
 	}

 	/**
 	* @expectedException InvalidArgumentException
 	*/
 	public function testsTiraExceptionSiNoSePasaParametro()
 	{
 		$this->fetch->run();
 	}

 	public function testsDescargaAssetSiLoEncuentra()
 	{
 		$this->fetch->run('jquery');
 		$this->assertFileExists(static::$jsDirectory.'jquery.js', "El archivo no fue descargado a la carpeta correcta");

 	}

 	public function testsAvisaAlUsuarioDelFin()
 	{
 		$this->fetch->run('jquery');

 		$this->expectOutputString('Descarga completa'. PHP_EOL);
 	}

 	public function testsGuardaEnDirectorioCorrecto()
 	{
 		$this->fetch->run('jquery');
 		$this->assertFileExists(static::$jsDirectory . 'jquery.js');


 		$this->fetch->run('normalize');
 		$this->assertFileExists(static::$cssDirectory . 'normalize.css');

 	}

 	public function testsNotificaUsuarioAssetDesconocido()
 	{ 		
 		$this->fetch->run('blabla');
 		$this->expectOutputString('Asset blabla desconocido'. PHP_EOL);
 	}
 }