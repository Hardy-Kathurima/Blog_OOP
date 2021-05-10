<?php
require '../database/connection.php';
$author = $title = $content = '';
$message = '';
$rnum = '';

if (isset($_POST['edit'])) {
    $edit_blog = mysqli_real_escape_string($conn, $_POST['edit_blog']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);

    $update = "UPDATE blog_details  SET title='$title', content='$content', author = '$author' WHERE id = $edit_blog ";

    if (mysqli_query($conn, $update)) {
        header('Location:../index.php');
    }
}



$id = $_GET['id'];

$select = 'SELECT * from blog_details WHERE id = ?';
$stmt = $conn->prepare($select);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$single_blog = $result->fetch_assoc();
$conn->close();

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
    <h2 class=" dispaly-4 mt-3 mb-3">Edit Blog</h2>
    <div class="message mt-2 mb-2">
        <?php echo $message; ?>
    </div>
    <form class="form" action="edit.php" method="post">
        <input type="hidden" name="edit_blog" value="<?php echo $single_blog['id']; ?>">
        <label for="author">Author:</label><br>
        <div class="input">
            <input type="text" name="author" id="author" value="<?php echo $single_blog['author']; ?>">
            <div class="errors">
                <?php echo $errors['author']; ?>
            </div>
        </div><br>
        <label for="title">Title:</label>
        <div class="input">
            <input type="text" name="title" id="title" value="<?php echo $single_blog['title']; ?>">
            <div class="errors">
                <?php echo $errors['title']; ?>
            </div>
        </div><br>
        <label for="content">Content:</label>
        <div class="input">
            <textarea name="content" id="content"><?php echo $single_blog['content']; ?></textarea>
            <div class="errors">
                <?php echo $errors['content']; ?>
            </div>
        </div><br>
        <div class="submit">
            <input class="btn btn-primary" type="submit" name="edit" value="Submit">
        </div>
    </form>
    <div class="error"></div>
</div>

<script src="../public/jquery-3.4.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/main.js"></script>
</body>

</html>