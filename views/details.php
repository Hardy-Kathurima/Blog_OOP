<?php
require '../database/connection.php';

$id = $_GET['id'];

$select = 'SELECT * from blog_details WHERE id = ?';
$stmt = $conn->prepare($select);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$single_blog = $result->fetch_assoc();
$conn->close();

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

    <div class="blogs bg-light mt-3 mb-3 p-2">
        <h3 class=" display-4 text-justify "><?php echo $single_blog['title']; ?></h3>
        <hr>
        <p class="lead"><?php echo $single_blog['content']; ?></p>
        <span class="text-dark text-right"><?php echo 'Author : ' . $single_blog['author']; ?></span><br>
        <span class=" text-center text-success"><?php echo 'Created at : ' . $single_blog['created_at']; ?></span><br>
        <span><a href="edit.php?id=<?php echo $single_blog['id']; ?>">Update article</a></span>
        &nbsp;<span><a href="#">Delete article</a></span>


    </div>


</div>

</body>

</html>