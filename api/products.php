<?php
include('db.php');
include('global.php');

$json = jsonResponse(0, "No request");

if(isset($_REQUEST["action"])){
	$action = $_REQUEST["action"];
	$json = jsonResponse(0, "Invalid request: $action");
	if($action == "get_products"){
		$json = jsonResponse(1, getProductsList());
	}else if($action == "add_product"){
        $json = addProduct($_REQUEST);
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
        if(!file_exists("../" . $products[$i]["image"]) || $products[$i]["image"] == ""){
            $products[$i]["image"] = "https://osss-tb.herokuapp.com/assets/placeholder.gif";
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
            $file_name = "$product_id-$subfile_name.jpg";
            saveFile($files["product_picture"], $file_name);
            $file_name = "images/$file_name";
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
?>