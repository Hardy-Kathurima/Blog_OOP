<?php
require 'database/connection.php';
$stmt = $conn->prepare("SELECT id,title,content,author FROM blog_details LIMIT ? ");
$limit = 5;
$stmt->bind_param('i',$limit);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id,$title,$content,$author);


$search_value='';
if(isset($_POST['search'])&& isset($_POST['search_value'])){

    $search_value = $_POST['search_value'];
    $stmt = $conn->prepare("SELECT id,author,title ,content FROM blog_details WHERE (title LIKE ? OR author LIKE ? OR content LIKE ?)  ");
    $like = '%'. $search_value .'%' ;
    $stmt->bind_param('sss',$like,$like,$like);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$author,$title,$content);

}
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
    <h2 class="text-center mt-3 mb-3">Blogs</h2>
    <form class="text-center" action="index.php" Method="POST">
        <div class="input">
       <input type="search" class="border border-info rounded p-2 mr-2 " name="search_value"  placeholder="search..." value="<?php echo $search_value; ?>"  >
       <input type="submit" value="Search" name="search" class="btn btn-info ">
       </div>
    </form>
    

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
    <?php echo '<div class="text-center mt-5 p-3  bg-light ">' ?>
    <?php echo 'No such blog exists!'; ?>
     <?php echo '<div>' ?>
    <?php endif; ?>

</div>

</body>

</html>