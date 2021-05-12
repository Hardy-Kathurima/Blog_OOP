<?php
require '../database/connection.php';
require_once '../validation/Validator.php';
$errors = ['author' => '', 'title' => '', 'content' => ''];



if (array_key_exists('id', $_GET)) {
    $id = htmlspecialchars($_GET['id']);
}

$stmt = $conn->prepare("SELECT id,title,content,author,created_at FROM blog_details WHERE id = ?");
$conn->error;
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $content, $author, $created_at);
$stmt->fetch();


if (isset($_POST['submit']) && isset($_POST['edit_blog'])) {
    $author = trim($_POST['author']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $edit_blog = trim($_POST['edit_blog']);

    // validate user input
    if (Validator::checkEmptyAuthor($author)) {
        $errors['author'] = ' author field cannot be empty';
    }

    if (Validator::checkEmptyTitle($title)) {
        $errors['title'] = ' title field cannot be empty';
    }

    if (Validator::checkEmptyContent($content)) {
        $errors['content'] = ' content field cannot be empty';
    }

    // check if error array contains errors
    if (array_filter($errors)) {
    } else {
        $stmt = $conn->prepare("UPDATE blog_details SET author = ?, title = ? ,content = ? WHERE id = ? LIMIT 1");
        $stmt->bind_param('sssi', $author, $title, $content, $edit_blog);
        $stmt->execute();

        header('Location:../index.php');
    }
}

// delete single blog

if (isset($_POST['delete']) && isset($_POST['delete_blog'])) {
    $delete_blog = $_POST['delete_blog'];

    $stmt = $conn->prepare("DELETE FROM blog_details WHERE id = ?");
    $stmt->bind_param('i', $delete_blog);
    $stmt->execute();

    header('Location:../index.php');
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
        <span type="button" class="btn " data-toggle="modal" data-target="#exampleModal">
            <img src="../public/images/edit.png" alt="edit_button">
        </span>

        <div class="mt-2">
            <form action="details.php" method="POST">
                <input type="hidden" name="delete_blog" value="<?php echo $id ?>">
                <input type="submit" class="btn btn-danger" onclick="return confirm('Delete Blog?')" value="Delete"
                    name="delete">
            </form>
        </div>

        <?php include '../templates/modal.php'; ?>

    </div>

    <?php include '../templates/footer.php'; ?>
</div>


<script src="../public/jquery-3.4.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/Popper.js"></script>
<script src="../public/main.js"></script>
</body>

</html>