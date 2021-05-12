<?php
require '../database/connection.php';
include_once '../validation/Validator.php';
$author = $title = $content = '';
$message = '';
$rnum = '';

$errors = ['author' => '', 'title' => '', 'content' => ''];
if (isset($_POST['submit'])) {
  $author = htmlspecialchars($_POST['author']);
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);

  // validate user input

  if (Validator::checkEmptyAuthor($author)) {
    $errors['author'] = ' author field cannot be empty';
  } else if (Validator::validateAuthor($author)) {
    $errors['author'] = '* author can only contain words and numbers.';
  }

  if (Validator::checkEmptyTitle($title)) {
    $errors['title'] = ' title field cannot be empty';
  } else if (Validator::validateTitle($title)) {
    $errors['title'] = '* author can only contain words and numbers.';
  }
  if (Validator::checkEmptyContent($content)) {
    $errors['content'] = ' content field cannot be empty';
  } else if (Validator::validateContent($content)) {
    $errors['content'] = '* Blog can only contain words and numbers & 2-100 words';
  }




  if (array_filter($errors)) {
  } else {
    // check if title already exists
    $stmt = $conn->prepare("SELECT title FROM blog_details WHERE title = ? LIMIT 1");
    echo $conn->error;
    $stmt->bind_param('s', $title);
    if (!$stmt->execute()) {
      echo $stmt->error;
    }
    $stmt->bind_result($title);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum == 0) {
      $stmt->close();

      $stmt = $conn->prepare("INSERT INTO blog_details(author,title,content) VALUES(?,?,?)");
      $stmt->bind_param('sss', $author, $title, $content);
      $stmt->execute();


      $message = '<div class="alert alert-success alert-dismissible text-center">
      Data successfully submitted</div> ';

      $title = '';
      $content = '';
      $author = '';


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
    <h2 class="  mt-2 mb-2">Add a Blog</h2>
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
            <textarea name="content" id="content" class="p-2"><?php echo $content; ?></textarea><br>
            <div class="errors">
                <?php echo $errors['content']; ?>
            </div>
        </div><br>
        <div class="submit">
            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        </div>
    </form>
    <div class="error"></div>
    <?php include '../templates/footer.php'; ?>
</div>

<script src="../public/jquery-3.4.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/main.js"></script>
</body>

</html>