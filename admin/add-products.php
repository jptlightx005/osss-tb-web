<?php
include('authenticate.php');
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
	<script type="text/javascript">
        function readURL(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function (e){
                    $('#product_photo')
                        .attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>

<body>
<div class="container">
	<div class="row">
		<a href="/admin/">Dashboard</a>
		<a href="products.php">Products</a>
	</div>
	<div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Add Product</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="products.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <img style="margin-bottom:10px;" class="img-responsive center-block img-rounded" id="product_photo" src="/assets/placeholder.gif" alt="Insert Image" width="304" height="236">
                        <div class="row">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-4">
                                <label class="btn btn-primary btn-file center-block btn-md">
                                    Browse <input type="file" style="display: none;" name="product_picture" onchange="readURL(this);">
                                </label>
                            </div>
                            <div class="col-xs-4"></div>
                        </div>
                        <label>Product name:</label>
                        <input class="form-control" type="text" name="product_name" required />
                        <label>Price:</label>
                        <input class="form-control" type="number" name="price" step="any" min="0" required />
                        <label>Inventory:</label>
                        <input class="form-control" type="number" name="inventory" required />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="add_product" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
            <div class="panel-footer">Product Info</div>
        </div>
     </div>
</div>
</body>

</html>
