<?php
require '../database/connection.php';
require_once '../validation/Validator.php';
$errors = ['author' => '', 'title' => '', 'content' => ''];

// check if the variable id is set
if (array_key_exists('id', $_GET)) {
  $id = htmlspecialchars($_GET['id']);
}

$stmt = $conn->prepare("SELECT id,title,content,author,created_at FROM blog_details WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $content, $author, $created_at);
$stmt->fetch();


if (isset($_POST['submit']) && isset($_POST['edit_blog'])) {
  $author = $_POST['author'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $edit_blog = $_POST['edit_blog'];

  // validate user input
  if (Validator::checkEmptyAuthor($author)) {
    $errors['author'] = ' author field cannot be empty';
  } else if (Validator::validateAuthor($author)) {
    $errors['author'] = 'please enter a valid author name';
  }

  if (Validator::checkEmptyTitle($title)) {
    $errors['title'] = ' title field cannot be empty';
  } else if (Validator::validateTitle($title)) {
    $errors['title'] = 'please enter a valid title';
  }

  if (Validator::checkEmptyContent($content)) {
    $errors['content'] = ' content field cannot be empty';
  } else if (Validator::validateContent($content)) {
    $errors['content'] = 'please enter  valid content';
  }

  // check if error array contains errors
  if (array_filter($errors)) {
  } else {
    $stmt = $conn->prepare("UPDATE blog_details SET author = ?, title = ? ,content = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param('sssi', $author, $title, $content, $edit_blog);
    $stmt->execute();

    header('Location:../index.php');

    $stmt->close();
    $conn->close();
  }
}


?>


<?php require '../templates/header.php'; ?>

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
    <form action="edit.php" method="POST" class="form mt-3">
        <input type="hidden" name="edit_blog" value=" <?php echo $id; ?> ">
        <label for="title">Title:</label><br>
        <div class="input">
            <input type="text" name="title" id="title" value=" <?php echo trim($title); ?> ">
        </div>
        <div class="errors"><?php echo $errors['title'] ?></div>
        <label for="content">Content:</label><br>
        <div class="input">
            <textarea name="content" id="content"> <?php echo trim($content); ?> </textarea>
        </div>
        <div class="errors"><?php echo $errors['content'] ?></div>
        <label for="author">Author:</label><br>
        <div class="input">
            <input type="text" name="author" id="author" value=" <?php echo trim($author); ?> ">
        </div>
        <div class="errors"><?php echo $errors['author'] ?></div>
        <div><br>
            <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        </div>
    </form>


</div>