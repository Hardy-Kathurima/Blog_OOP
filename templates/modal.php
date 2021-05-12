<?php
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="details.php" method="POST" class="form ">
                    <input type="hidden" name="edit_blog" value=" <?php echo $id; ?> ">
                    <label for="title">Title:</label><br>
                    <div class="input">
                        <input type="text" name="title" id="title" value=" <?php echo trim($title); ?> ">
                    </div>
                    <div class="errors"><?php echo $errors['title'] ?></div>
                    <label for="content">Content:</label><br>
                    <div class="input">
                        <textarea class="p-2" name="content" id="content"> <?php echo trim($content); ?> </textarea>
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

        </div>
    </div>
</div>