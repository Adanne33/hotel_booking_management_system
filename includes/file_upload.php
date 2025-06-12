<?php

try {
    // check if the file uploaded is greater than the post_max_size limit
    if (empty($_FILES)){
        throw new Exception("Invalid upload");
    }

    switch ($_FILES['file']['error']){
        case UPLOAD_ERR_OK;
        break;
        case UPLOAD_ERR_NO_FILE:
            throw new Exception("No file uploaded");
            break;
        case UPLOAD_ERR_INI_SIZE:
            // file uploaded size is greater than the upload_max_size limit
            throw new Exception("File is too large!");
            break;
        default:
            throw new Exception("An error occurred when uploading!");
    }

    // set the upload size limit to 10MB
    if ($_FILES['file']['size'] > 10485760){
        throw new Exception("File size is too large!");
    }

    // specify the MIME type 
    $mime_types = ['image/png', 'image/jpg', 'image/jpeg'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

    // if the file is not of any of the mime types specified above
    if (!in_array($mime_type, $mime_types)){
        throw new Exception("Invalid file type uploaded.");
    }

    // ** Add this block for dimension check **
    list($width, $height) = getimagesize($_FILES['file']['tmp_name']);
    if ($width > 350 && $height > 200) {
        throw new Exception("Invalid image dimensions. Required: 350x200 pixels.");
    }

    // prevent filename from code injections
    $pathinfo = pathinfo($_FILES['file']['name']);
    $base = $pathinfo['filename'];
    // replace any characters that ain't proper letters, numbers or whatever
    $base = preg_replace("/[^a-zA-Z0-9_-]/", "_", $base);
    // limits the filename to 100 characters max
    $base = mb_substr($base, 0, 100);

    $filename = $base . "." . $pathinfo['extension'];
    $destination = "./uploads/$filename";

    // check if the filename already exists first, if it does, modify the name with numbering
    $i = 1;
    while (file_exists($destination)){
        $filename = $base . "-$i." . $pathinfo['extension'];
        $destination = "./uploads/$filename";
        $i++;
    }

    // moves the file to the uploads dir inside our project
    move_uploaded_file($_FILES['file']['tmp_name'], $destination);


} catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
}