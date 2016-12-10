<?php


// 'images' refers to your file input name attribute
if (empty($_FILES['images'])) {
    echo json_encode(['error'=>'No files found for upload.']);
    // or you can throw an exception
    return; // terminate
}

// get the files posted
$images = $_FILES['images'];

// a flag to see if everything is ok
$success = null;

// file paths to store
$paths= [];

// coded names to store
$coded_names=[];

// get file names
$filenames = $images['name'];

// extra data
$extra_size= $_POST['extra_size'];
$extra=[];
for ($i=0; $i < $extra_size; $i++) {
    $extra[]= $_POST['new_'.$i];
}


// loop and process files

for($i=0; $i < count($filenames); $i++){
    $ext = explode('.', basename($filenames[$i]));
    $new_coded_name=md5(uniqid());
    $target = "data/documents/attachments" . "/" . $new_coded_name . "." . array_pop($ext);

    if(move_uploaded_file($images['tmp_name'][$i], $target)) {
        $success = true;
        $paths[] = $target;
        $coded_names[]= $new_coded_name;
    } else {
        $success = false;
        break;
    }
}

// check and process based on successful status
if ($success === true) {
    // call the function to save all data to database
    // code for the following function `save_data` is not
    // mentioned in this example

    //save_data($userid, $username, $paths);

    // store a successful response (default at least an empty array). You
    // could return any additional response info you need to the plugin for
    // advanced implementations.
    $output = [];
    // for example you can get the list of files uploaded this way
    $output = [ 'filenames_original' => $filenames,
                'filenames_by_server' => $coded_names,
                'paths' => $paths,
                'filenames_by_user' => $extra
              ];
} elseif ($success === false) {
    $output = ['error'=>'Error while uploading images. Contact the system administrator'];
    // delete any uploaded files
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = ['error'=>'No files were processed.'];
}
// return a json encoded response for plugin to process successfully
echo json_encode($output);


?>
