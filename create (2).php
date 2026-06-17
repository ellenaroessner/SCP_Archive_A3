<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "connection.php";

$successMessage = "";

if(isset($_POST['submit'])) {

    $subject = $_POST['subject'];
    $item = $_POST['item'];
    $class = $_POST['class'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $containment = $_POST['containment'];

    $stmt = $connection->prepare("
        INSERT INTO scp_entries (subject, item, class, image, description, containment)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if($stmt && $stmt->bind_param("ssssss", $subject, $item, $class, $image, $description, $containment) && $stmt->execute()) {
        $successMessage = "
            <div class='section'>
                <div class='section-tag'>STATUS</div>
                <div class='section-body'>ENTRY SUCCESSFULLY CREATED</div>
            </div>
        ";
    } else {
        $successMessage = "
            <div class='section'>
                <div class='section-tag'>ERROR</div>
                <div class='section-body'>Failed to create entry</div>
            </div>
        ";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create SCP Entry</title>

    <link rel="stylesheet" href="scp_detective_archive.css">
</head>

<body>

<div class="container">

<!-- Top bar -->
<div class="topbar">
    <div class="logo-box">SCP ARCHIVE</div>

    <div class="topbar-right">
        <div class="access-level">ENTRY CREATION MODULE</div>
    </div>
</div>

<!-- Main grid -->
<div class="main-grid">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="sidebar-block">
            <div class="sidebar-label">System Status</div>

            <div class="meta-row">
                <div class="meta-key">Connection</div>
                <div class="meta-text-values green">ONLINE</div>
            </div>

            <div class="meta-row">
                <div class="meta-key">Mode</div>
                <div class="meta-text-values amber">CREATE</div>
            </div>
        </div>

        <div class="sidebar-block">
            <div class="sidebar-label">Navigation</div>
            <a href="index.php" class="btn">Return to Archive</a>
        </div>

    </div>

    <!-- Content section -->
    <div class="content-pane">

        <div class="content-header">
            <div class="item-id">CREATE SCP ENTRY</div>
            <div class="item-subtitle">DATABASE INPUT TERMINAL</div>
        </div>

        <?php echo $successMessage; ?>

        <!-- Create form -->
        <form method="POST">

            <div class="section">
                <div class="section-tag">Subject</div>
                <div class="section-body">
                    <input type="text" name="subject" required>
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Item #</div>
                <div class="section-body">
                    <input type="text" name="item" required>
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Object Class</div>
                <div class="section-body">
                    <input type="text" name="class" required>
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Image URL</div>
                <div class="section-body">
                    <input type="text" name="image">
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Description</div>
                <div class="section-body">
                    <textarea name="description" required></textarea>
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Containment Procedures</div>
                <div class="section-body">
                    <textarea name="containment" required></textarea>
                </div>
            </div>

            <div class="section">
                <button type="submit" name="submit" class="btn">Submit Entry</button>
            </div>

        </form>

    </div>

</div>

</div>

</body>
</html>