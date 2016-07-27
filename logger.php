<?php
abstract class Logger{
	protected $massege;
	protected $log_time;
	protected $host = 'localhost';
	protected $user = 'root';
	protected $password = '123';
	protected $db = 'test';
	public function get_date($error){
		@$this->log_time = date("[Y-m-d H:i:s]").serialize($error);
	}
	public function write_log_in_file(){
	}
}
class FileLogger extends Logger{
	private $way = 'log.txt';
	public function write_log_in_file(){
		return file_put_contents($this->way, $this->log_time . "\n", FILE_APPEND);
	}
}
class DBLogger extends Logger{
	public function __construct($host = 'localhost', $user = 'root',$password = '123',$db = 'test'){
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->db = $db;
	}
	public function write_log_in_file(){
		$connect = mysqli_connect($this->host,$this->user,$this->password,$this->db);
		if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
		}
		$sql = mysqli_query($connect, "INSERT INTO Logg (massege) VALUES('error')");
		mysqli_close($connect);
	}
}
$Log = new FileLogger('/log.txt');
$Log->get_date('Error');
$Log->write_log_in_file();

$mysqliLog = new DBLogger();
$mysqliLog->write_log_in_file();
?>
