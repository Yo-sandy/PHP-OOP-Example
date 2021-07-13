<?php

require_once "welcome.php";

$db = new DB("localhost","root","","sandeep");
$message = "";

$sname = null;
$english = null;
$hindi = null;
$math = null;
$science = null;
$sscience = null;
$physical = null;
$btn_name  = "insert";
$btn_value = "Save Report";


if (isset($_GET['message']) && !empty($_GET['message'])){
    $message = "<div class='alert alert-success' role='alert'>Report  Updated Successfully</div>";
}

if (isset($_GET['edit']) && !empty($_GET['edit'])){
    $query = "SELECT * FROM students WHERE id=" .$_GET['edit'];
    $boy = $db->selectOne($query);
    $sname = $boy['sname'];
    $english = $boy['english'];
    $hindi = $boy['hindi'];
    $math = $boy['math'];
    $science = $boy['science'];
    $sscience = $boy['sscience'];
    $physical= $boy['physical'];
    $btn_name  = "update";
    $btn_value = "Update Report";
}


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['insert'])){
        $sname = $_POST['sname'];
        $english = $_POST['english'];
        $hindi = $_POST['hindi'];
        $math = $_POST['math'];
        $science = $_POST['science'];
        $sscience = $_POST['sscience'];
        $physical = $_POST['physical'];
        $id = $db->insert("INSERT INTO students(sname,english,hindi,math,science,sscience,physical) VALUES(:sname,:english,:hindi,:math,:science,:sscience,:physical)",[
            ":sname" => $sname,
            ":english" => $english,
            ":hindi" => $english,
            ":math" => $english,
            ":science" => $english,
            ":sscience" => $english,
            ":physical" => $english,
        ]);
        echo "Data Inserted";
        if ($id){
            $message = '<div class="alert alert-success" role="alert"> Report Added Successfully </div>';
        }
    }
    if (isset($_POST['update'])){
        $sname = $_POST['sname'];
        $english = $_POST['english'];
        $hindi = $_POST['hindi'];
        $math = $_POST['math'];
        $science = $_POST['science'];
        $sscience = $_POST['sscience'];
        $physical = $_POST['physical'];

        $isSuccess = $db->update("UPDATE students SET sname=:sname,english=:english,hindi=:hindi,math=:math,science=:science,sscience=:sscience,physical=:physical WHERE id=" .$_GET['edit'],[
            ":sname" => $sname,
            ":english" => $english,
            ":hindi" => $hindi,
            ":math" => $math,
            ":science" => $science,
            ":sscience" => $sscience,
            ":physical" => $physical,
        ]);
        if ($isSuccess){
            header("Location:http://sandy_php_example.test/upload.php?message=update");
        }
    }
}


$students = $db->select("SELECT *, (english + hindi + math + science + sscience + physical) AS total FROM students");
$products = $db->select("SELECT  * FROM products Limit 3");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        CRUD Operation php OOP PDO
    </title>
    <style>

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $message; ?>
            <h2>Students Report Card</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="sname" class="form-control" value="<?php echo $sname; ?>">
                </div>
                <div class="form-group">
                    <label for="english">English</label>
                    <input type="number" name="english" class="form-control" value="<?php echo $english; ?>">
                </div>
                <div class="form-group">
                    <label for="hindi">Hindi</label>
                    <input type="number" name="hindi" class="form-control" value="<?php echo $hindi; ?>">
                </div>
                <div class="form-group">
                    <label for="math">Math</label>
                    <input type="number" name="math" class="form-control" value="<?php echo $math; ?>">
                </div>
                <div class="form-group">
                    <label for="science">Science</label>
                    <input type="number" name="science" class="form-control" value="<?php echo $science; ?>">
                </div>
                <div class="form-group">
                    <label for="sscience">SScience</label>
                    <input type="number" name="sscience" class="form-control" value="<?php echo $sscience; ?>">
                </div>
                <div class="form-group">
                    <label for="physical">Physical</label>
                    <input type="number" name="physical" class="form-control" value="<?php echo $physical; ?>">
                </div>
                <button class="btn btn-primary" name="<?php echo $btn_name;?>">
                    <?php echo $btn_value; ?>
                </button>
            </form>
        </div>
        <div class="col-md-12 mt3">
            <h2>Posts</h2>
            <table class="table table-hover table-bordered">
                <tr><th>Id</th>
                    <th>Name</th>
                    <th>English</th>
                    <th>Hindi</th>
                    <th>Math</th>
                    <th>Science</th>
                    <th>SScience</th>
                    <th>Physical</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($students as $student){
                    ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['sname']; ?></td>
                        <td><?php echo $student['english']; ?></td>
                        <td><?php echo $student['hindi']; ?></td>
                        <td><?php echo $student['math']; ?></td>
                        <td><?php echo $student['science']; ?></td>
                        <td><?php echo $student['sscience']; ?></td>
                        <td><?php echo $student['physical']; ?></td>
                        <td><?php echo $student['total']; ?></td>
                        <td><a href="?edit=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a></td>
                    </tr>
                <?php } ?>
            </table>
            <table class="table table-hover table-bordered mt-3">
                <tr>
                    <th>Id</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($products as $product){ ?>
                    <tr>
                        <td><?php echo $product['id'] ?></td>
                        <td><?php echo $product['productName'] ?></td>
                        <td><?php echo $product['unit'] ?></td>
                        <td><?php echo $product['price'] ?></td>
                        <td>
                            <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php  } ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>