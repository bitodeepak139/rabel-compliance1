<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function uploadImage($image_name, $newName, $target_dir, $allowedExt = array('jpeg', 'jpg', 'png', 'gif', 'JPEG', 'JPG', 'PNG', 'GIF', 'PDF', 'pdf','MP4','mp4'))
{
    try {
        $fileName = $_FILES[$image_name]['name'];
        $tmpFileName = $_FILES[$image_name]['tmp_name'];
        $size = $_FILES[$image_name]['size'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // $newName = "Doc-" . $doc_name . rand(1000, 1000000) . "." . $ext;
        if (in_array($ext, $allowedExt)) {
            if ($size < 5000000) {
                $check = move_uploaded_file($tmpFileName, $target_dir . $newName);

                if($check == 1){
                    print_r('File is uploaded successfully');
                    echo "<br>";
                    
                    // print the folder permission code 
                    echo "Folder Permission Code- ". substr(sprintf('%o', fileperms($target_dir)), -4);

                    echo "<br>";

                    if(is_writable($target_dir)){
                        print_r('Folder is writable');
                    }else{
                        print_r('Folder is not writable');
                    }
                }else{
                    print_r('Move uploaded function failed');
                }
            } else {
                // return array('status' => "0", "msg" => "File Must be less than 5MB");
                print_r('File Must be less than 5MB');
            }
        } else {
            $msg = "";
            $allowedExt = array_unique($allowedExt);
            $revisedExt = array();
            foreach ($allowedExt as $extension) {
                $extension = strtoupper($extension);
                array_push($revisedExt, $extension);
            }
            $newAllowedExt = array_unique($revisedExt);
            foreach ($newAllowedExt as $value) {
                $msg .= $value . " ";
            }
            // return array('status' => "0", "msg" => "Please upload File with " . $msg . "Extension Only");
            print_r('Please upload File with ' . $msg . 'Extension Only');
        }
    } catch (\Throwable $th) {
        return $th;
    }
}


function RenameImage($image_name)
{
    try {
        $fileName = $_FILES[$image_name]['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newName = $image_name . "-" . time() . mt_rand(100000, 10000000) . "." . $ext;
        return $newName;
    } catch (\Throwable $th) {
        return $th;
    }
}

if(isset($_POST['submit'])){

    $fileName = $_FILES['file']['name'];
    $tmpFileName = $_FILES['file']['tmp_name'];

  
    $newName = RenameImage('file');
    $target_dir = "upload/certificate/";
    $upload = uploadImage('file', $newName, $target_dir ,array('PDF', 'pdf'));

    $uploadedFile = $target_dir.$newName;

    echo "<a href='$uploadedFile' target='_blank'>Download</a>";
    echo "<br>";
    echo "This File will only show once";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype='multipart/form-data'>
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>