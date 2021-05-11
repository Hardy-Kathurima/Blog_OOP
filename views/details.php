<?php
require '../database/connection.php';


    if(array_key_exists('id',$_GET)){
        $id = htmlspecialchars($_GET['id']);
    }

    $stmt = $conn->prepare("SELECT id,title,content,author,created_at FROM blog_details WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$title,$content,$author,$created_at);
    $stmt->fetch();
    


if(isset($_POST['delete']) && isset($_POST['delete_blog'])){
    $delete_blog = $_POST['delete_blog'];

    $stmt = $conn->prepare("DELETE FROM blog_details WHERE id = ?");
    $stmt->bind_param('i',$delete_blog);
    $stmt->execute();

     header('Location:../index.php');

     $stmt->close();
    $conn->close();

}










?>

<?php include '../templates/header.php' ?>

<nav class="navbar navbar-expand-sm bg-light justify-content-center">
    <a class="navbar-brand text-dark " href="../index.php">|--BLOG--|</a>

    <!-- Links -->
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="add.php">Add blog</a>
        </li>

    </ul>

</nav>

<div class="container">

    <div class="blogs bg-light mt-3 mb-3 p-5">
        <h3 class=" display-6  "><?php echo $title; ?></h3>
        <hr>
        <p class="lead"><?php echo $content; ?></p>
        <span class="text-dark text-right"><?php echo 'Author : ' . $author; ?></span><br>
        <span class=" text-center text-success"><?php echo 'Created at : ' . $created_at; ?></span>
        <span><a href="edit.php?id=<?php echo $id; ?>"><img src="../public/images/edit.png" alt=""></a></span>
        <div class="mt-2"><form action="details.php" method="POST">
            <input type="hidden" name="delete_blog" value="<?php echo $id ?>">
            <input type="submit" class="btn btn-danger" onclick="return confirm('Delete Blog?')" value="Delete" name="delete">
        </form></div>


    </div>


</div>

</body>

</html>