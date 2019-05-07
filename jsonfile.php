<?php
// $namee = "waluyooo";
// $_REQUEST['Action']="Upload";
// $_REQUEST['FileName']=$namee;

if (isset($_REQUEST['Action'])){
  $action=trim($_REQUEST['Action']);
  echo $action;
} else {
  $action="";
}

if (isset($_REQUEST['FileName'])){
  $namefile=trim($_REQUEST['FileName']);
  echo $namefile;
} else {
  $namefile="";
}
$appresult = array();

if (isset($_REQUEST['DeviceID'])){$DeviceID=trim($_REQUEST['DeviceID']);} else {$DeviceID="";}
if (isset($_REQUEST['SimSerialNumber'])){$SimSerialNumber=trim($_REQUEST['SimSerialNumber']);} else {$SimSerialNumber="";}
if (isset($_REQUEST['SubscriberID'])){$SubscriberID=trim($_REQUEST['SubscriberID']);} else {$SubscriberID="";}

$file_handle = fopen('./multipartpost.log', 'a+');
fwrite($file_handle, "======================================"."\r\n");
foreach($_REQUEST as $name => $value){
	fwrite($file_handle, date("d.m.Y H:i:s", time()).": ".$name."=".$value."\r\n");
}
fwrite($file_handle, "======================================"."\r\n");

function GetWebname($name){
	$name=str_replace("�", "Ae", $name);
	$name=str_replace("�", "Oe", $name);
	$name=str_replace("�", "Ue", $name);
	$name=str_replace("�", "ae", $name);
	$name=str_replace("�", "oe", $name);
	$name=str_replace("�", "ue", $name);
	$name=str_replace("�", "ss", $name);
	$name=str_replace(" ", "_", $name);
	$name=str_replace("'", "", $name);
	$name=str_replace("�", "", $name);
	$name=str_replace("&", "and", $name);
	$name=str_replace("/", "", $name);
	$name=str_replace("\\", "", $name);
	$name=str_replace("`", "", $name);
	return strtolower($name);
}
function rand_string($lng=8) {
	mt_srand((double)microtime()*1000000);
	$charset = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
	$length  = strlen($charset)-1;
	$code    = '';
	for($i=0;$i < $lng;$i++) {
	  $code .= $charset{mt_rand(0, $length)};
	}
	return $code;
}

if ($action == "Upload") {
  $uploads[] = array();
  fwrite($file_handle, "======= FILES ========================"."\r\n");
  foreach($_FILES as $name => $value){
    $uploads[$name] = $value;
    foreach($value as $fname => $fvalue){
    	fwrite($file_handle, date("d.m.Y H:i:s", time()).": ".$fname."=".$fvalue."\r\n");
    }
  	fwrite($file_handle, date("d.m.Y H:i:s", time()).": Upload of \"".$name."\"\r\n");
    if($name==$namefile){
      $uploaddir = './uploads/';
      $uploadfile = $uploaddir . basename($_FILES[$name]['name']);
     	fwrite($file_handle, date("d.m.Y H:i:s", time()).": MoveUploadedFile(".$_FILES[$name]['name'].")\r\n");
      if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
        $uploads[$name]["status"] = $_FILES[$name]['name']." saved successfull";
      	fwrite($file_handle, date("d.m.Y H:i:s", time()).": ->moving ".$_FILES[$name]['name']." successfull\r\n");
          #echo "Datei ist valide und wurde erfolgreich hochgeladen.\n";
      } else {
        $uploads[$name]["status"] = $_FILES[$name]['name']." failed to save!";
      	fwrite($file_handle, date("d.m.Y H:i:s", time()).":->moving ".$_FILES[$name]['name']." NOT successfull\r\n");
          #echo "M�glicherweise eine Dateiupload-Attacke!\n";
      }
    }
    foreach($value as $fname => $fvalue){
    	fwrite($file_handle, date("d.m.Y H:i:s", time()).": ".$fname."=".$fvalue."\r\n");
    }
  }
  fwrite($file_handle, "======================================"."\r\n");
	#print_r($uploads);
  $appresult["uploads"] = $uploads;

  echo json_encode($appresult);
  #
}else{
}
fclose($file_handle);
// $img = file_get_contents("php://input");// datanya udah di encode dalam bentuk string jadinya kayak gini 'data:image/png;base64,AAAFBfj42Pj4';
// $img = str_replace('data:image/jpg;base64,', '', $img);
// $img = str_replace(' ', '+', $img);
// $data = base64_decode($img);
// $namefile = date("Ymd-His", time());
// file_put_contents('./uploads/'.$namefile.'.jpg', $data);
// // ambil data file
// $namaFile = $_FILES['berkas']['name'];
//
// // tentukan lokasi file akan dipindahkan
// $dirUpload = "uploads/";
//
// // pindahkan file
// $terupload = move_uploaded_file($namaFile, $dirUpload.$namaFile);
//
// if ($terupload) {
//     echo "Upload berhasil!<br/>";
// } else {
//     echo "Upload Gagal!";
// }

?>
