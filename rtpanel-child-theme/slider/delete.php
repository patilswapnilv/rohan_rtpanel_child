<?php 

if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action == 'delete'){
		$filename = $_GET['filename'];
		$path = '../images/'.$filename;
		unlink($path);
		$newURL = '../../../../wp-admin/themes.php?page=rtp_home_slider_child';
		header('Location: '.$newURL);
		}
	if($action == 'add'){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 1000000)
		&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    if (file_exists("../images/" . $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../images/" . $_FILES["file"]["name"]);
	  $newURL = '../../../../wp-admin/themes.php?page=rtp_home_slider_child';
  		header('Location: '.$newURL);
    }
  }
} else {
  echo "Invalid file or filesize is larger";
}
		}
	}
	
	

?>