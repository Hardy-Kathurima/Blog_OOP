<?php
require 'database/connection.php';
$select = 'SELECT * from blog_details LIMIT 10';
$result = $conn->query($select);
$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);

$conn->close();




?>
<?php include 'templates/header.php'; ?>

<nav class="navbar navbar-expand-sm bg-light justify-content-center">
    <a class="navbar-brand text-dark " href="index.php">|--BLOG--|</a>

    <!-- Links -->
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="views/add.php">Add blog</a>
        </li>

    </ul>

</nav>
<div class="container">
    <h1 class="text-center mt-3 mb-3">Blogs</h1>

    <?php if (count($blogs) > 0) : ?>

    <?php foreach ($blogs as $blog) : ?>
    <div class="blogs bg-light p-4 mt-3 mb-3">

        <h3><a href="views/details.php?id=<?php echo $blog['id']; ?>">
                <?php echo $blog['title']; ?>
            </a></h3>
        <div> <?php echo $blog['content']; ?> </div>
        <span> <?php echo 'Author: ' . $blog['author']; ?> </span>

    </div>
    <?php endforeach; ?>



    <?php else : ?>
    <?php echo 'no blogs found'; ?>
    <?php endif; ?>



</div>

</body>

</html>