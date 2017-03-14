<?php
include('authenticate.php');

if(isset($_REQUEST['action'])){
    if($_REQUEST['action'] == "add_product"){
        $fields = $_REQUEST;
        $fields["file"] = $_FILES;
        $url = urlToApi('/api/products.php');
        $obj = jsonFromRequest($fields, $url);
    }
}

$url = urlToApi('/api/products.php?action=get_products');
$params = array("api_key" => getenv("API_KEY"));
$obj = jsonFromRequest($params, $url);

$product_list = $obj["message"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap Core CSS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
	<div class="row">
		<a href="/admin/">Dashboard</a>
		<a href="products.php">Products</a>
	</div>
	<div class="row">
        <h2>Products</h2> 
        <a href="add-products.php" class="btn btn-primary btn-md">
            <span class="glyphicon glyphicon-plus"></span>Add Products
        </a>
        <a href="products.php" class="btn btn-primary btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Refresh
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Inventory</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($product_list as $dict){ ?>
                <tr>
                    <td><?php echo $dict["ID"]; ?></td>
                    <td><?php echo $dict["product_name"]; ?></td>
                    <td><?php echo $dict["price"]; ?></td>
                    <td><?php echo $dict["inventory"]; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
	</div>
</div>
</body>

</html>