<?php
    require_once "welcome.php";

    $db = new DB("localhost", "root", "", "sandeep");
    $message = "";

    $productName = null;
    $unit = null;
    $price = null;
    $btn_name = "insert";
    $btn_value = "Add Product";

if (isset($_GET['delete']) && !empty($_GET['delete'])){
    $query = "DELETE FROM products WHERE id=" .$_GET['delete'];
    $delete = $db->delete($query);
    if ($delete){
        $message = "<div class='alert alert-success' role='alert'>Delete Products Successfully</div>";
    }
}

    if (isset($_GET['message']) && !empty($_GET['message'])){
        $message = "<div class='alert alert-success' role='alert'>Product Updated Successfully </div>";
    }


    if (isset($_GET['edit']) && !empty($_GET['edit'])){
        $query = "SELECT * FROM products  WHERE id=" .$_GET['edit'];
        $product = $db->selectOne($query);

        $productName = $product['productName'];
        $unit = $product['unit'];
        $price = $product['price'];
        $btn_name = "update";
        $btn_value = "Update Product";
    }

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['insert'])){
        $productName = $_POST['productName'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];

        $id = $db->insert("INSERT INTO products(productName,unit,price) VALUES(:productName,:unit,:price)",[
                ":productName" => $productName,
                ":unit" => $unit,
                ":price" => $price,
                ]);
        echo "Data Inserted";
        if ($id){
            $message = "<div class='alert alert-success' role='alert'>Data Added Successfully</div>";
        }
    }
    if (isset($_POST['update'])){
        $productName = $_POST['productName'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];

        $isSuccess = $db->update("UPDATE products SET productName=:productName,unit=:unit,price=:price WHERE id=" .$_GET['edit'],[
                ":productName" => $productName,
                ":unit" => $unit,
                ":price" => $price,
        ]);
        if ($isSuccess){
            header("Location:http://sandy_php_example.test/test1.php?message=update");
        }
    }
}

$totalProducts = $db->select("SELECT count( * ) as total_Id FROM products");
$products = $db->select("SELECT ProductName, unit + ', ' + price AS showRates FROM products");

    ?>

    <!DOCTYPE html>
    <html>
<head>
    <title>Test_1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <?php echo $message; ?>
    <div class="container">
        <h2>Products Testing</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" name="productName" value="<?php echo $productName; ?>">
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <input type="text" class="form-control" name="unit" value="<?php echo $unit; ?>">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" value="<?php echo $price; ?>">
            </div>
            <button class="btn btn-primary mt-3" name="<?php echo $btn_name; ?>" >
                <?php echo $btn_value; ?>
            </button>
        </form>
        <table class="table table-hover table-bordered mt-3">
            <tr> 
                <th>Id</th>
                <th>Fruit</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($products as $product){ ?>
            <tr>
<!--                 <td>--><?php //echo $product['id'] ?><!--</td>-->
<!--                 <td>--><?php //echo $product['productName'] ?><!--</td>-->
<!--                 <td>--><?php //echo $product['unit'] ?><!--</td>-->
<!--                 <td>--><?php //echo $product['price'] ?><!--</td>-->
                 <td><?php echo $product['ProductName'] ?></td>
                 <td><?php echo $product['showRates'] ?></td>
                <td>
                    <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
                <?php  } ?>
        </table>
        <h3>Total Product = <?php echo count($products) ?></h3>
    </div>
</body>
</html>