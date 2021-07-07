<?php

require_once "welcome.php";

$db = new DB("localhost","root","","sandeep");
$message = "";

$title = null;
$body = null;
$btn_name  = "insert";
$btn_value = "Save Post";

// Delete Method
if (isset($_GET['delete']) && !empty($_GET['delete'])){
    $query = "DELETE FROM posts WHERE id=" .$_GET['delete'];
    $delete = $db->delete($query);
    if ($delete){
        $message = '<div class="alert alert-success" role="alert"> Post Deleted Successfully  </div>';
    }
}
// Delete Method Close

if (isset($_GET['message']) && !empty($_GET['message'])){
    $message =  '<div class="alert alert-success" role="alert"> Post Updated Successfully  </div>';
}

if (isset($_GET['edit']) && !empty($_GET['edit'])){
    $query = "SELECT title, body FROM posts WHERE id=" .$_GET['edit'];
    $user = $db->selectOne($query);

    $title = $user['title'];
    $body = $user['body'];
    $btn_name = "update";
    $btn_value = "Update Post";
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['insert'])){
        $title = $_POST['title'];
        $body = $_POST['body'];

        $id = $db->insert("INSERT INTO posts(title, body)VALUES(:title ,:body)",[
            ":title" => $title,
            ":body" => $body,
        ]);
        echo "Data Inserted";
        if ($id){
            $message = '<div class="alert alert-success" role="alert"> Post Added Successfully  </div>';
        }
    }


    if (isset($_POST['update'])){
        $title = $_POST['title'];
        $body = $_POST['body'];

        $isSuccess = $db->update("UPDATE posts SET title=:title, body=:body WHERE id=" .$_GET['edit'],[
            ":title" => $title,
            ":body" => $body,
        ]);
        if ($isSuccess){
            header("Location:http://sandy_php_example.test/post.php?message=update");
        }
    }
}

$posts = $db->select("SELECT * FROM posts");

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
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Your title" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea name="body" id="body" class="form-control"><?php echo $body; ?></textarea>
                </div>

                <button class="btn btn-primary" name="<?php echo $btn_name;?>">
                    <?php echo $btn_value; ?>
                </button>
            </form>
        </div>
        <div class="col-md-12 mt3">
            <h2>Posts</h2>
            <table class="table table-hover table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created Time</th>
                    <th>Updated Time</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($posts as $post){
                    ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['body']; ?></td>
                        <td><?php echo $post['created_at']; ?></td>
                        <td><?php echo $post['updated_at']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $post['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?delete=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
