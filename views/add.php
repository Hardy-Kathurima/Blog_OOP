<?php
require '../database/connection.php';
$author = $title = $content = '';
$message = '';
$rnum = '';

$errors = ['author' => '', 'title' => '', 'content' => ''];
if (isset($_POST['submit'])) {
  $author = htmlspecialchars($_POST['author']);
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);
  if (empty($author)) {
    $errors['author'] = 'author field cannot be empty';
  } else {
    $author =  trim($_POST['author']);
    if (!preg_match('/^[a-z\d_\s]{2,20}$/i', $author)) {
      $errors['author'] = 'Please enter a valid author name.';
    }
  }
  if (empty($title)) {
    $errors['title'] = 'title field cannot be empty';
  } else {
    $title =  trim($_POST['title']);
    if (!preg_match('/^[a-z\d_\s]{2,20}$/i', $title)) {
      $errors['title'] = 'Please enter a valid title.';
    }
  }
  if (empty($content)) {
    $errors['content'] = 'content field cannot be empty';
  } else {
    $content =  trim($_POST['content']);
    if (str_word_count($_POST['content']) > 300) {
      $errors['content'] = 'comment cannot exceed 300 words';
    }
  }

  if (array_filter($errors)) {
  } else {
    // check if title exists
    $stmt = $conn->prepare("SELECT title FROM blog_details WHERE title = ? LIMIT 1");
    $stmt->bind_param('s', $title);
    $stmt->execute();
    $stmt->bind_result($title);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum == 0) {
      $stmt->close();

      $stmt = $conn->prepare("INSERT INTO blog_details(author,title,content) VALUES(?,?,?)");
      $stmt->bind_param('sss', $author, $title, $content);
      $stmt->execute();


      $message = '<div class="alert alert-success alert-dismissible text-center">
      Data successfully submited</div> ';
      //header('Location:../index.php');
      $stmt->close();
    } else {
      $errors['title'] = 'Title already exists';
    }
  }
}
?>

<?php include '../templates/header.php'; ?>
<nav class="navbar navbar-expand-sm bg-light justify-content-center">
    <a class="navbar-brand text-dark " href="../index.php">|--BLOG--|</a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
        </li>


    </ul>

</nav>
<div class="container">
    <h2 class=" dispaly-4 mt-3 mb-3">Add a Blog</h2>
    <div class="message mt-2 mb-2">
        <?php echo $message; ?>
    </div>
    <form class="form" action="add.php" method="post">
        <label for="author">Author:</label><br>
        <div class="input">
            <input type="text" name="author" id="author" value="<?php echo $author; ?>">
            <div class="errors">
                <?php echo $errors['author']; ?>
            </div>
        </div><br>
        <label for="title">Title:</label>
        <div class="input">
            <input type="text" name="title" id="title" value="<?php echo $title; ?>">
            <div class="errors">
                <?php echo $errors['title']; ?>
            </div>
        </div><br>
        <label for="content">Content:</label>
        <div class="input">
            <textarea name="content" id="content"><?php echo $content; ?></textarea>
            <div class="errors">
                <?php echo $errors['content']; ?>
            </div>
        </div><br>
        <div class="submit">
            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        </div>
    </form>
    <div class="error"></div>
</div>

<script src="../public/jquery-3.4.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/main.js"></script>
</body>

</html>