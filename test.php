<?php 

 
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}


mysql_connect('localhost','root','root');
mysql_select_db('booing_engine');
     
$data = array();

if(isset($_GET['bookings'])){

	$result = mysql_query('SELECT * FROM bookings');
	while ($row = mysql_fetch_assoc($result)) {
		$data[] = $row;
	}
	echo json_encode($data);	 
	exit;
}

if(isset($_GET['id'])){
	
	$id = (int) $_GET['id'];
	$result = mysql_query('SELECT * FROM bookings WHERE id ='.$id);
	$data = mysql_fetch_assoc($result);

	echo json_encode($data);	 
	exit;
}

if(isset($_GET['update'])){
	
	$data = json_decode(file_get_contents('php://input'), true);
	if($data){
		$sql = 'UPDATE bookings SET name="'.$data['name'].'", mobile="'.$data['mobile'].'", email="'.$data['email'].'", notes="'.$data['notes'].'",booking_date="'.$data['booking_date'].'" WHERE id='.  $data['id'];
		
		if(mysql_query($sql)){
			echo json_encode(array('success' => 'Booking updated successfully'));	 
		}
		else{
			echo json_encode(array('error' => 'Data not saved'));	 
		}

	}
	exit;
}

if(isset($_GET['delete'])){

	$data = json_decode(file_get_contents('php://input'), true);

	if(isset($data['id'])){
		$sql = 'DELETE FROM bookings WHERE id='.$data['id'];
		if(mysql_query($sql)){
			echo json_encode(array('success' => 'Booking deleted successfully'));
		}
		else {
			echo json_encode(array('error' => 'Can not delete booking'));
		}

	}
	
}

if(isset($_GET['add'])){

	$data = json_decode(file_get_contents('php://input'), true);
 
	if($data){
		$sql = 'INSERT INTO bookings SET name="'.$data['name'].'", mobile="'.$data['mobile'].'", email="'.$data['email'].'", notes="'.$data['notes'].'",booking_date="'.$data['booking_date'].'"';
		
		if(mysql_query($sql)){
			echo json_encode(array('success' => 'Booking added successfully'));	 
		}
		else{
			echo json_encode(array('error' => 'Data not saved'));	 
		}

	} 
	 
	exit;
}



$username = 'deepak643462';
$password = 3392;
//$username = 'internal';
//$password = '111333';
$sender_id = urlencode('LOCOVL');

$message = " HiOTPis" ;
$message = rawurlencode($message);
$mobile = 9023048866;
// Send the POST request with cURL

$url = "http://www.kit19.com/ComposeSMS.aspx?username=".$username."&password=".$password."&sender=".
$sender_id."&to=".$mobile."&message=".$message."&priority=1&dnd=1&unicode=0";

 

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);  

if($response == 'Sent.'){
	echo 'message sent';
}
else{
	var_dump($response);
	//echo 'fail';
}


?>