<?php
require 'database/connection.php';
$stmt = $conn->prepare("SELECT id,title,content,author FROM blog_details LIMIT ? ");
$limit = 5;
$stmt->bind_param('i',$limit);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id,$title,$content,$author);
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

    <?php if ($stmt->num_rows > 0) : ?>

    <?php while ($stmt->fetch()) : ?>
    <div class="blogs bg-light p-4 mt-3 mb-3">

        <h3><a href="views/details.php?id=<?php echo $id; ?>">
                <?php echo $title; ?>
            </a></h3>
        <div> <?php echo $content ?> </div>
        <span> <?php echo 'Author: ' . $author; ?> </span>
    </div>
    <?php endwhile; ?>
    <?php else : ?>
    <?php echo 'no blogs found'; ?>
    <?php endif; ?>

</div>

</body>

</html>