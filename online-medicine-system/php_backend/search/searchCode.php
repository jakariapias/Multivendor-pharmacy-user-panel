<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchData = $_POST['searchData'];
    $searchOption = $_POST['searchOption'];

    if ($searchOption == "type_medicine" || $searchOption == "type_pharmacy") {

        $sql_searchByPharmacy = "SELECT
        pa.id,
        pa.shop_name,
        pa.shop_image,
        pad.latitude,
        pad.longitude,
        pad.address
        FROM pharmacy_admin pa
        JOIN pharmacy_address pad ON pa.id = pad.pharmacy_id
        WHERE pa.shop_name LIKE '%$searchData%'";

        $sql_searchByMedicine = "SELECT DISTINCT pa.id,
        pa.shop_name,
        pa.shop_image,
        pad.latitude,
        pad.longitude,
        pad.address
        FROM product p
        JOIN pharmacy_admin pa ON p.pharmacy_id = pa.id
        JOIN pharmacy_address pad ON pa.id = pad.pharmacy_id
        WHERE p.prd_name ='$searchData'";

        $main_sql = $searchOption == "type_medicine" ? $sql_searchByMedicine : $sql_searchByPharmacy;

        $result = mysqli_query($conn, $main_sql);


        if ($result) {
            $row_count = mysqli_num_rows($result);

            if($row_count >0){
                $resultData=[];
                while ($row = mysqli_fetch_array($result)) {
                    $id=$row["id"];
                    $shopName=$row["shop_name"];
                    $shopImage=$row["shop_image"];
                    $latitude=$row["latitude"];
                    $longitude=$row["longitude"];
                    $address=$row["address"];
    
                    $dataArray=array(
                        "id"=>$id,
                        "shopName"=>$shopName,
                        "shopImage"=>$shopImage,
                        "address"=>$address,
                        "latitude"=>$latitude,
                        "longitude"=>$longitude,
                    );
    
                    $resultData[]=$dataArray;
                    
                }
                echo json_encode(["isSuccess" => true, "data" => ["resultData" =>  $resultData], "message" => "Succeed to search pharmacy"]);
            }
            else{
                echo json_encode(["isSuccess" => false, "data" => ["status"=>"noFound"], "message" => $searchOption == "type_medicine" ?"Medicine Not Found!":"Pharmacy Not Found!"]);
            }
           

        }
        else{
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" =>"Something went wrong" ]);
        }

    }
    else{
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "select_search_category"]);
    }



} else {
    // If the request method is not POST, return an error
    http_response_code(405);
    echo 'Method Not Allowed';
    echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Failed to search."]);
}