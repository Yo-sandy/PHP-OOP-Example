<?php

require_once "welcome.php";

$db = new DB("localhost","root","","sandeep");
$message = "";

$name = "";
$email = "";
$password = "";
$btn_name  = "insert";
$btn_value = "Save user";

// Delete Method
if (isset($_GET['delete']) && !empty($_GET['delete'])){

    $query = "DELETE FROM users WHERE id=" .$_GET['delete'];
    $delete = $db->delete($query);
    if ($delete){
        $message = '<div class="alert alert-success" role="alert"> User Deleted Successfully  </div>';
    }
}
// Delete Method Close

if (isset($_GET['message']) && !empty($_GET['message'])){
    $message =  '<div class="alert alert-success" role="alert"> User Updated Successfully  </div>';
}

if (isset($_GET['edit']) && !empty($_GET['edit'])){
    $query = "SELECT name, email, password FROM users WHERE id=" .$_GET['edit'];
    $user = $db->selectOne($query);

    $name = $user['name'];
    $email = $user['email'];
    $password = $user['password'];
    $btn_name = "update";
    $btn_value = "update user";
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['insert'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $id = $db->insert("INSERT INTO users(name, email, password)VALUES(:name ,:email,:password)",[
           ":name" => $name,
           ":email" => $email,
           ":password" => $password,
        ]);
        echo "Data Inserted";
        if ($id){
            $message = '<div class="alert alert-success" role="alert"> User Added Successfully  </div>';
        }
    }


if (isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $isSuccess = $db->update("UPDATE users SET name=:name, email=:email, password=:password WHERE id=" .$_GET['edit'],[
       ":name" => $name,
       ":email" => $email,
       ":password" => $password,
    ]);
    if ($isSuccess){
        header("Location:http://sandy_php_example.test?message=update");
    }
  }
}

$users = $db->select("SELECT * FROM users");

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
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Your Name" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Enter Your Password" value="<?php echo $password; ?>">
                    </div>
                    <button class="btn btn-primary" name="<?php echo $btn_name;?>">
                        <?php echo $btn_value; ?>
                    </button>
                </form>
            </div>
            <div class="col-md-12 mt3">
                <h2>Users</h2>
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Register Time</th>
                        <th>Updated Time</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        foreach ($users as $user){
                    ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['name'] ;?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['password']; ?></td>
                            <td><?php echo $user['created_at']; ?></td>
                            <td><?php echo $user['updated_at']; ?></td>
                            <td>
                                <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    </body>
</html>
