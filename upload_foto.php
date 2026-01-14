<?php 
function upload_foto($File){    
	$uploadOk = 1;
	$hasil = array();
	$message = '';
 
	//File properties:
	$FileName = $File['name'];
	$TmpLocation = $File['tmp_name'];
	$FileSize = $File['size'];

	//Figure out what kind of file this is:
	$FileExt = explode('.', $FileName);
	$FileExt = strtolower(end($FileExt));

	//Allowed files:
	$Allowed = array('jpg', 'png', 'gif', 'jpeg');  

	// No file size limit enforced here. Note: PHP server settings (upload_max_filesize and post_max_size) still apply.
	// If you want to enforce a limit, add a check here, e.g.:
	// if ($FileSize > 500000) { $message .= "Sorry, your file is too large"; $uploadOk = 0; }

	// Allow certain file formats
	if(!in_array($FileExt, $Allowed)){
		$message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
		$uploadOk = 0; 
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$message .= "Sorry, your file was not uploaded. ";
		$hasil['status'] = false; 
		// if everything is ok, try to upload file
	}else{
		//Ensure destination directory exists and is writable
		$destDir = __DIR__ . '/img/';
		if (!is_dir($destDir)) {
			if (!@mkdir($destDir, 0755, true)) {
				$message .= "Upload directory does not exist and could not be created. ";
				$hasil['status'] = false; return $hasil;
			}
		}
		if (!is_writable($destDir)) {
			$message .= "Upload directory is not writable. ";
			$hasil['status'] = false; return $hasil;
		}

		//Create new filename:
        $NewName = date("YmdHis"). '.' . $FileExt;
        $UploadDestination = $destDir . $NewName; 

		if (move_uploaded_file($TmpLocation, $UploadDestination)) {
			//echo "The file has been uploaded.";
			$message .= $NewName;
			$hasil['status'] = true; 
		}else{
			$message .= "Sorry, there was an error moving the uploaded file to the destination. ";
			$hasil['status'] = false; 
		}
	}
	
	$hasil['message'] = $message; 
	return $hasil;
}
?>