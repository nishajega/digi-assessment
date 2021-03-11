<?php  
error_reporting(0);
$message='';
 if(isset($_POST["btn_zip"]))  
 {  
      $output = '';  
      if($_FILES['zip_file']['name'] != '')  
      {  
           $file_name = $_FILES['zip_file']['name'];  
           $array = explode(".", $file_name);  
           $name = $array[0];  
           $ext = $array[1];  
           if($ext == 'zip')  
           {  
                $path = 'upload/';  
                $location = $path . $file_name;  
                if(move_uploaded_file($_FILES['zip_file']['tmp_name'], $location))  
                {  
                     $zip = new ZipArchive;  
                     if($zip->open($location))  
                     {  
                          $zip->extractTo($path);  
                          $zip->close();  
                     }  
                     $files = scandir($path);  
                     //$name is extract folder from zip file  
                     foreach($files as $file)  
                     {  
                          $file_ext = end(explode(".", $file));  
                          $allowed_ext = array('jpg', 'png');  
                          if(in_array($file_ext, $allowed_ext))  
                          {  
                               $new_name = md5(rand()).'.' . $file_ext;  
                               $output .= '<div class="col-md-6"><img src="upload/'.$new_name.'" width="170" height="240" /></div>';  
                               copy($path.'/'.$file, $path . $new_name);  
                               unlink($path.'/'.$file);  
                          }       
                     }  
                     unlink($location);  
                     rmdir($path);  
                }  
           }else{
			   $message = "<p>The file you are trying to upload is not a .zip file. Please try again.</p>";
		   }			   
      }  
 }else{
			   $message = "<p>No image found. Your extracted images should be here.</p>";
		   }	  
 ?> 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Engineering Internship Assessment</title>
  <meta name="description" content="The HTML5 Herald" />
  <meta name="author" content="Digi-X Internship Committee" />

  <link rel="stylesheet" href="style.css?v=1.0" />
  <link rel="stylesheet" href="custom.css?v=1.0" />

</head>

<body>

    <div class="top-wrapper">
        <img src="https://assets.website-files.com/5cd4f29af95bc7d8af794e0e/5cfe060171000aa66754447a_n-digi-x-logo-white-yellow-standard.svg" alt="digi-x logo" height="70" />
        <h1>Engineering Internship Assessment</h1>
		<a href="counter.html" style= "float: right; margin-right: 50px;" class="button button1">               	
            Back
		</a>
    </div>

    <div class="instruction-wrapper">
		 <form style="background: #222222; border: none; color: #ffffff;" method="post" enctype="multipart/form-data">
			<h4 style="margin-top:31px;">Please select a zip file</h4><br>
			<input style="margin-left: 9px;" type="file" name="zip_file"/>
			<br><br>
			<input type="submit" name="btn_zip" class="btn btn-info" value="Upload" />
		</form>
    </div>
	
    <div class="display-wrapper">
        <h2 style="margin-top:51px;">My images</h2>
        <div class="append-images-here">
			<?php
				if(isset($message)){
				echo $message;
				}
				if(isset($output))
				{
					echo $output;
				}
				?>
            <!-- THE IMAGES SHOULD BE DISPLAYED INSIDE HERE -->
        </div>
    </div>
    <!-- DO NO REMOVE CODE UNTIL HERE -->

</body>
</html>