<?php
require_once "welcome.php";

    $db = new DB("localhost","root","","sandeep");
    $message = "";

$name = null;
$btn_name = "insert";
$btn_value = "Save Item";

if (isset($_POST['message']) && !empty($_POST['message'])){
    $message = "<div class='alert alert-success' role='alert'>Order Updated Successfully</div>";
}

if (isset($_GET['delete']) && !empty($_GET['delete'])){
    $query = "DELETE FROM orders WHERE id=" .$_GET['delete'];
    $delete = $db->delete($query);
}

if (isset($_GET['edit']) && !empty($_GET)){
    $query = "SELECT name FROM orders WHERE id=" .$_GET['edit'];
    $order = $db->selectOne($query);
    $name = $order ['name'];
    $btn_name = "update";
    $btn_value = "Update Item";
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['insert'])){
        $name = $_POST['name'];

        $id = $db->insert("INSERT INTO orders(name) VALUES(:name)",[
            ":name" => $name,
        ]);
        if ($id){
            $message = "<div class='alert alert-success' role='alert'>Order Add Successfully</div>";
        }
    }

    if (isset($_POST['update'])){
        $name = $_POST['name'];

       $isSuccess = $db->update("UPDATE orders SET name=:name WHERE id=" .$_GET['edit'],[
           ":name" => $name,
       ]);
        if ($isSuccess){
           header("Location:http://sandy_php_example.test/test2.php?message=update");
        }
    }
}

$orders = $db->select("SELECT * FROM orders");

?>

<!DOCTYPE html>
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<head>
    <body>
    <div>
        <h2>Orders Example</h2>
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <button name="<?php echo $btn_name; ?>" class="btn btn-primary">
                    <?php echo $btn_value; ?>
            </button>
        </form>
        <div>
            <h3>Table CRUD Operation</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($orders as $order){ ?>
                <tr>
                    <td><?php echo $order['id'] ?></td>
                    <td><?php echo $order['name'] ?></td>
                    <td>
                        <a href="?edit=<?php echo $order['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="?delete=<?php echo $order['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</head>
</html>
