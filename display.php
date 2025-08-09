<?php
include 'connect.php';

// Fetch all images from database
$sql = "SELECT id, image FROM profile ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Profile</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="table_container">
    <table class="table">
      <thead>
        <tr class="head">
          <th>ID</th>
          <th>Profile Image</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                        <td>{$row['id']}</td>
                        <td><img src='{$row['image']}' alt='Profile Image'></td>
                      </tr>";
          }
        } else {
          echo "<tr><td colspan='2'>No images uploaded yet.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <a href="index.php" class="link">Back</a>
</body>

</html>