<?php
include 'connect.php';
$error = "";
$success = "";

if (isset($_POST['submit'])) {
  $image = $_FILES['image_field'];

  if (!empty($image['name'])) {
    $imageFileName = $image['name'];
    $imageFileTemp = $image['tmp_name'];

    $fileExtension = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
    $image_extensions = ['jpeg', 'jpg', 'png'];

    if (in_array($fileExtension, $image_extensions)) {
      $newFileName = uniqid("img_", true) . '.' . $fileExtension;
      $upload_image = 'images/' . $newFileName;

      if (move_uploaded_file($imageFileTemp, $upload_image)) {
        $upload_image_safe = mysqli_real_escape_string($conn, $upload_image);
        $insert_image = "INSERT INTO profile (image) VALUES ('$upload_image_safe')";
        $result = mysqli_query($conn, $insert_image);

        if ($result) {
          $success = "✅ Data inserted successfully";
        } else {
          $error = "❌ Database Error: " . mysqli_error($conn);
        }
      } else {
        $error = "❌ Failed to move uploaded file.";
      }
    } else {
      $error = "❌ Invalid file type. Only JPEG, JPG, and PNG allowed.";
    }
  } else {
    $error = "❌ Please select an image.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Card</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>

  <div class="container">
    <div class="form_container">
      <h2>Profile Card</h2>

      <?php if (!empty($success)) : ?>
        <div class="success-msg"><?php echo $success; ?></div>
      <?php endif; ?>

      <?php if (!empty($error)) : ?>
        <p class="error_message"><?php echo $error; ?></p>
      <?php endif; ?>

      <form action="" method="post" enctype="multipart/form-data">
        <div class="form_group">
          <input type="file" class="input_field" name="image_field" required>
        </div>
        <div class="form_group">
          <input type="submit" class="submit_btn" name="submit" value="Upload">
        </div>
      </form>
      <a href="display.php" class="link">View Profile</a>
    </div>
  </div>

  <script>
    setTimeout(function() {
      document.querySelectorAll('.success-msg, .error_message').forEach(function(el) {
        el.style.display = 'none';
      });
    }, 3000); // Hide after 3 seconds
  </script>

</body>

</html>