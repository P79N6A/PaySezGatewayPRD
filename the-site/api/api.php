<?php	
require_once("rest.inc.php");

class API extends REST {

	public $data = "";
	const DB_SERVER = "10.10.90.5";
	const DB_USER = "root";
	const DB_PASSWORD = "25kUHbWZTA";
	const DB = "profitorius";

	private $db = NULL;

	public function __construct(){
		parent::__construct();				// Init parent contructor
		$this->dbConnect();					// Initiate Database connection
	}
	
	/*
	 *  Database connection 
	*/
	private function dbConnect(){
		$this->db = ($GLOBALS["___mysqli_ston"] = mysqli_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD));
		if($this->db)
			((bool)mysqli_query($this->db, "USE " . constant('self::DB')));
	} 
	
	/*
	 *	Encode array into JSON
	*/
	private function json($data){
		if(is_array($data)){
			return json_encode($data);
		}
	}
	
	/*
	 * Public method for access api.
	 * This method dynmically call the method based on the query string
	 *
	 */
	public function processApi(){
		$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
		if((int)method_exists($this,$func) > 0)
			$this->$func();
		else
			$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
	}
	
	private function void() {
		
		if($this->get_request_method() != "GET"){
			$this->response('',406);
		}

		$notify_img = $this->_request["notify_img"];
		$notify_txt = $this->_request["notify_txt"];
		$email = $this->_request["email"];
		$query = "SELECT ID FROM players WHERE email = '".$email."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$row = mysqli_fetch_array($result);
		$userID = $row['ID'];
		$sql = "INSERT INTO notifications SET  userid=".$userID.",notify_img = '".$notify_img."', notify_txt = '".$notify_txt."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
		$success = array('status' => "Success", "result" => $sql);
		$this->response($this->json($success),200);
	}
	
	private function refund() {
		
		if($this->get_request_method() != "GET"){
			$this->response('',406);
		}

		$notify_img = $this->_request["notify_img"];
		$notify_txt = $this->_request["notify_txt"];
		$email = $this->_request["email"];
		$query = "SELECT ID FROM players WHERE email = '".$email."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$row = mysqli_fetch_array($result);
		$userID = $row['ID'];
		$sql = "INSERT INTO notifications SET  userid=".$userID.",notify_img = '".$notify_img."', notify_txt = '".$notify_txt."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
		$success = array('status' => "Success", "result" => $sql);
		$this->response($this->json($success),200);
	}
	
	private function capture() {
		
		if($this->get_request_method() != "GET"){
			$this->response('',406);
		}

		$award = $this->_request["award"];
		$email = $this->_request["email"];
		$reason = $this->_request["reason"];
		
		if($reason = "purchase"){
			$award_type = "1";
			$result = file_get_contents('http://accounting.cardgenius.com/api/api.php?rquest=buyPoints&email='.$_POST["email"].'&award='.$award.'&award_type='.$award_type.'&reason=purchase', 0, stream_context_create(array( 'http' => array( 'timeout' => 1 ) ) ));
			$result = json_decode($result, true);
			
			if(!isset($result)) {
				$jsonsql = "INSERT INTO api_fail SET call='http://accounting.cardgenius.com/api/api.php?rquest=buyPoints&email=".$_POST['email']."&award=".$award."&award_type=".$award_type."&reason=purchase'";
			}

		}

		$query = "SELECT ID FROM players WHERE email = '".$email."'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$row = mysqli_fetch_array($result);
		$userID = $row['ID'];
		$query ="UPDATE `stats` SET `winpot` = winpot + ".$award." WHERE `userid` = '".$userID."' ";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$success = array('status' => "Success", $result => "done");
		$this->response($this->json($success),200);
	}


}

// Initiiate Library
$api = new API;
$api->processApi();
?>
