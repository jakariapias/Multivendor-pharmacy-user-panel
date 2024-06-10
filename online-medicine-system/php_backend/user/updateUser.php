<?php
include('../../config/dbConn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $userId = $_POST['userId'];
        settype($userId,'integer');
        $name = $_POST['userName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $newImage = isset($_FILES['updatedUserImage']) ? $_FILES['updatedUserImage']['name'] : '';
        $prevImageName = $_POST['prevUserImageName'];
        $filename = $prevImageName;

        if ($newImage != '') {
            $allowed_extension = array('png', 'jpg', 'jpeg');
            $file_extension = pathinfo($newImage, PATHINFO_EXTENSION);
            $filename = time() . '.' . $file_extension;
        }

        $userAddressId = $_POST['userAddressId'];
        $address = $_POST['address'];
        $street = $_POST['streetName'];
        $city = $_POST['city'];
        $post_office = $_POST['postOffice'];
        $latLong = explode(',', $_POST['latLong']);

        $latitude = floatval($latLong[0]);
        $longitude = floatval($latLong[1]);


        // Update user's email
        $userSql = "UPDATE user SET `name`='$name', `email`='$email', `phone`='$phone', `image`='$filename' WHERE id=$userId";
        $result = mysqli_query($conn, $userSql);

        if ($result) {
            // Update user's email
            $userAddressSql = "UPDATE user_address SET `house_name`='$address', `street`='$street', `post_office`='$post_office', `city`='$city', `latitude`=$latitude, `longitude`=$longitude WHERE address_id=$userAddressId";
            $addressSqlResult = mysqli_query($conn, $userAddressSql);
            if ($addressSqlResult) {
                if ($newImage) {
                    $folderPath = "../../assets/img/user/";
                    deleteImageFromFolder($prevImageName, $folderPath);

                    $targetedFile=$_FILES['updatedUserImage']['tmp_name'];
                    uploadImage($filename, $folderPath,$targetedFile);
                }
                $_SESSION['userUpdate']=true;
                echo json_encode(["isSuccess" => true, "data" => ["error" => $userSql . " || " . $userAddressSql], "message" => "User Updated Successfully"]);

            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn),"userAddressSql"=>$userAddressSql], "message" => "Failed to Update User"]);
            }

        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn),"userSql"=>$userSql], "message" => "Failed to Update User"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to Update User"]);
    }
}


// Function to delete image
function deleteImageFromFolder($prevImageName , $folderPath)
{

    if ($prevImageName) {
        // Specify the path to the folder and the filename to be deleted
        $fileName = $prevImageName; // Replace with the actual file name

        // Check if the file exists before attempting to delete
        $filePath = $folderPath . $fileName;
        if (file_exists($filePath)) {
            // Attempt to delete the file
            unlink($filePath);
        } 
    }

}

// Function to upload an image to a folder
function uploadImage($filename, $targetFolder,$targetedFile)
{
     // Set the destination path
     $destination = $targetFolder . $filename;
     // Move the file to the destination
     move_uploaded_file($targetedFile, $destination);
}


?>