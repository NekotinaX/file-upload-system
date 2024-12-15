Here's the translated code into English:

```php
<?php
session_start();
require 'db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Maximum file size in bytes (10MB)
define('MAX_FILE_SIZE', 10 * 1024 * 1024);

// Allowed image formats
$allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

// File upload processing
if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $file = $_FILES['file'];
    $image = $_FILES['image'];

    // Check if a file is selected
    if ($file['error'] === 0 && $image['error'] === 0) {
        // Check the file size
        if ($file['size'] > MAX_FILE_SIZE) {
            echo "The file size is too large. Maximum size: 10MB.";
            exit();
        }

        // Check if the image is of an allowed type
        if (!in_array($image['type'], $allowed_image_types)) {
            echo "Invalid image format. Allowed formats: JPG, PNG, GIF.";
            exit();
        }

        // Retrieve file data
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // Generate a new name for the file to avoid name conflicts
        $new_file_name = uniqid() . '.' . $file_ext;
        $file_path = 'uploads/' . $new_file_name;

        // Move the main file to the target directory
        if (!move_uploaded_file($file_tmp, $file_path)) {
            echo "Error uploading the file.";
            exit();
        }

        // Upload the image
        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        // Generate a new name for the image
        $new_image_name = uniqid() . '.' . $image_ext;
        $image_path = 'uploads/images/' . $new_image_name;

        // Check if the image directory exists; if not, create it
        if (!is_dir('uploads/images')) {
            mkdir('uploads/images', 0777, true);
        }

        // Move the image to the target directory
        if (!move_uploaded_file($image_tmp, $image_path)) {
            echo "Error uploading the image.";
            exit();
        }

        // Save the resource information in the database
        $stmt = $conn->prepare("INSERT INTO resources (name, description, file_path, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $description, $file_path, $image_path);
        $stmt->execute();
        $stmt->close();

        echo "The file and image were successfully uploaded!";
    } else {
        echo "Please select a file and an image!";
    }
}

// File download handling
if (isset($_GET['download_id'])) {
    $resource_id = $_GET['download_id'];
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    // Insert the download into the database
    $stmt = $conn->prepare("INSERT INTO downloads (user_id, resource_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $user_id, $resource_id);
    $stmt->execute();
    $stmt->close();

    // Retrieve the file path
    $stmt = $conn->prepare("SELECT file_path FROM resources WHERE id = ?");
    $stmt->bind_param('i', $resource_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Redirect to the file for download
    if (file_exists($file_path)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
}

// Retrieve all resources from the database with download counts
$stmt = $conn->prepare("
    SELECT r.id, r.name, r.description, r.file_path, r.image_path, 
    IFNULL(COUNT(d.id), 0) AS download_count
    FROM resources r
    LEFT JOIN downloads d ON r.id = d.resource_id
    GROUP BY r.id
");
$stmt->execute();
$stmt->bind_result($id, $name, $description, $file_path, $image_path, $download_count);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resources</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('img/login-bag.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Background dimming */
            z-index: -1;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .content {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 800px;
            color: #e0e0e0;
        }
        h2, h3 {
            color: #ff9800;
            text-align: center;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #e0e0e0;
            display: block;
        }
        input[type="text"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #292929;
            color: #e0e0e0;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff9800;
            border: none;
            border-radius: 5px;
            color: #1e1e1e;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ffb74d;
        }
        .resource-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .resource-item img {
            max-width: 100px;
            margin-right: 15px;
        }
        .download-count {
            font-weight: bold;
            color: #ff9800;
            font-size: 14px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Welcome to the Dashboard!</h2>

            <h3>Add a New Resource</h3>
            <form method="POST" enctype="multipart/form-data">
                <label for="name">Resource Name:</label>
                <input type="text" name="name" required><br>

                <label for="description">Resource Description:</label>
                <textarea name="description" required></textarea><br>

                <label for="file">Select a File to Upload:</label>
                <input type="file" name="file" required><br>

                <label for="image">Select an Image for the Resource:</label>
                <input type="file" name="image" accept="image/*" required><br>

                <button type="submit" name="upload">Upload File</button>
            </form>

            <h3>Select a Resource to Download</h3>
            <?php while ($stmt->fetch()): ?>
                <div class="resource-item">
                    <div>
                        <img src="<?php echo $image_path; ?>" alt="Image of <?php echo $name; ?>">
                        <strong><?php echo $name; ?></strong>
                        <span class="download-count">(<?php echo $download_count; ?>)</span>
                        <p><?php echo $description; ?></p>
                    </div>
                    <a href="?download_id=<?php echo $id; ?>">
                        <button>Download <?php echo $name; ?></button>
                    </a>
                </div>
            <?php endwhile; ?>

            <?php $stmt->close(); ?>
        </div>
    </div>
</body>
</html>
```