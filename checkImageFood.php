<?php
$servername = "localhost";
$username = "admin";

function sendImage($image){
    //$isImage = system('python isImgFood.py http://res.cloudinary.com/doazmoxb7/image/upload/v1460929747/noodles_c4gq9p.jpg');
    //$isImage = system('python isImgFood.py myargs', "$image");
//    $isImage = exec("python /var/www/zero-to-slim.dev/src/isImgFood.py $image");
   // echo $image;
    $isImage = shell_exec('/usr/bin/python /var/www/zero-to-slim.dev/src/isImgFood.py http://res.cloudinary.com/doazmoxb7/image/upload/v1460929747/noodles_c4gq9p.jpg');
    //$isImage = exec("/usr/lib/python2.6 /Users/rupalsanghavi/'Box Sync'/Databases/VM/zero-to-slim.dev/src/isImgFood.py " . $image);
//    print_r($isImage);
    return $isImage;
    //echo $isImage;
    //echo $image;
}
?>
