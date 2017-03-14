<?php
include('db.php');
include('global.php');

require __DIR__ . '/../vendor/autoload.php';

$json = jsonResponse(0, "Invalid request");

if(isset($_REQUEST["action"]) && isset($_REQUEST["api_key"])){
	$action = $_REQUEST["action"];
	
	$api_key = getenv("API_KEY");
	$json = jsonResponse(0, "Authentication Failed");
	if($api_key == $_REQUEST["api_key"]){
		$json = jsonResponse(0, "Invalid request: $action");
		if($action == "get_products"){
			$json = jsonResponse(1, getProductsList());
		}else if($action == "add_product"){
			$json = addProduct($_REQUEST);
		}
	}
}

$conn->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);

/* methods */
function getProductsList(){
	global $conn;
	$query = "SELECT * FROM tbl_products WHERE inventory > 0";
	$products = selectQuery($query);
    for($i = 0; $i < count($products); $i++){
        if(!is_url_exist($products[$i]["image"]) || $products[$i]["image"] == ""){
            $products[$i]["image"] = "https://osss-tb.herokuapp.com/assets/placeholder.gif";
        }else{
			$milliseconds = round(microtime(true) * 1000);
			$image = $products[$i]["image"];
			$products[$i]["image"] .= "?$milliseconds";
		}
    }
    return $products;
}

function addProduct($product){
    global $conn;
    $product_name = addslashes($product["product_name"]);
    $inventory = addslashes($product["inventory"]);
    $price = addslashes($product["price"]);
    $query = "INSERT INTO tbl_products (product_name, inventory, price) VALUES ('$product_name', '$inventory', '$price')";
    $stmt = $conn->prepare($query);
    if($stmt->execute()){
        $product_id = $stmt->insert_id;
        $file_name = "assets/placeholder.gif";
        $files = $_REQUEST["file"];
        if($files["product_picture"]["error"] != UPLOAD_ERR_NO_FILE){

            $subfile_name = replace_accents(friendly_url($product["product_name"]));
            $file_name = "$product_id-$subfile_name";
			
			$result = \Cloudinary\Uploader::upload($files["product_picture"]["tmp_name"],	array("public_id" => "$file_name"));
            $file_name = $result["url"];
        }
        $query = "UPDATE tbl_products SET image = '$file_name' WHERE ID = $product_id";
        $stmt = $conn->prepare($query);
        if(!$stmt->execute()){
            unlink($file_name);
        }

        return jsonResponse(1,  "Successfully added product");
    }else{
        return jsonResponse(0,  "Failed to add product");
    }
}

function is_url_exist($url){
	$ch = curl_init($url);    
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200){
		$status = true;
	}else{
		$status = false;
	}
	curl_close($ch);
	return $status;
}
?>