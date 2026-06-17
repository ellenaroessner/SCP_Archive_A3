<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

$row = [];
$message = "";


   // LOAD EXISTING RECORD
if (isset($_GET['update'])) {

    $id = $_GET['update'];

    $recordID = $connection->prepare("SELECT * FROM scp_entries WHERE id = ?");

    if ($recordID) {

        $recordID->bind_param("i", $id);

        if ($recordID->execute()) {

            $temp = $recordID->get_result();
            $row = $temp->fetch_assoc();

        } else {
            $message = "<div class='section'><div class='section-tag'>ERROR</div><div class='section-body'>Failed to load record</div></div>";
        }

    } else {
        $message = "<div class='section'><div class='section-tag'>ERROR</div><div class='section-body'>Prepare failed</div></div>";
    }
}


    // Update record php
if (isset($_POST['update'])) {

    $update = $connection->prepare("
        UPDATE scp_entries 
        SET subject=?, item=?, class=?, description=?, containment=?, image=? 
        WHERE id=?
    ");

    if ($update) {

        $update->bind_param(
            "ssssssi",
            $_POST['subject'],
            $_POST['item'],
            $_POST['class'],
            $_POST['description'],
            $_POST['containment'],
            $_POST['image'],
            $_POST['id']
        );

        if ($update->execute()) {
            $message = "
                <div class='section'>
                    <div class='section-tag'>STATUS</div>
                    <div class='section-body'>RECORD SUCCESSFULLY UPDATED</div>
                </div>
            ";
        } else {
            $message = "
                <div class='section'>
                    <div class='section-tag'>ERROR</div>
                    <div class='section-body'>{$update->error}</div>
                </div>
            ";
        }

    } else {
        $message = "<div class='section'><div class='section-tag'>ERROR</div><div class='section-body'>Prepare failed</div></div>";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update SCP Record</title>

    <link rel="stylesheet" href="scp_detective_archive.css">
</head>

<body>

<div class="container">

<!-- Navbar -->
<div class="topbar">
    <div class="logo-box">SCP ARCHIVE</div>
    <div class="topbar-right">
        <div class="access-level">RECORD MODIFICATION MODULE</div>
    </div>
</div>

<!-- Main section -->
<div class="main-grid">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="sidebar-block">

            <div class="sidebar-label">System Status</div>

            <div class="meta-row">
                <div class="meta-key">Mode</div>
                <div class="meta-text-values amber">EDIT</div>
            </div>

            <div class="meta-row">
                <div class="meta-key">Connection</div>
                <div class="meta-text-values green">ONLINE</div>
            </div>

        </div>

        <div class="sidebar-block">
            <div class="sidebar-label">Navigation</div>
            <a href="index.php" class="btn">Return to Archive</a>
        </div>

    </div>

    <!-- Content -->
    <div class="content-pane">

        <div class="content-header">
            <div class="item-id">UPDATE ENTRY</div>
            <div class="item-subtitle">EDIT SCP DATABASE RECORD</div>
        </div>

        <?php echo $message; ?>

        <form method="post">

            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

            <div class="section">
                <div class="section-tag">Subject</div>
                <div class="section-body">
                    <input type="text" name="subject" value="<?php echo $row['subject'] ?>">
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Item #</div>
                <div class="section-body">
                    <input type="text" name="item" value="<?php echo $row['item'] ?>">
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Object Class</div>
                <div class="section-body">
                    <input type="text" name="class" value="<?php echo $row['class'] ?>">
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Image URL</div>
                <div class="section-body">
                    <input type="text" name="image" value="<?php echo $row['image'] ?>">
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Description</div>
                <div class="section-body">
                    <textarea name="description"><?php echo $row['description'] ?></textarea>
                </div>
            </div>

            <div class="section">
                <div class="section-tag">Containment Procedures</div>
                <div class="section-body">
                    <textarea name="containment"><?php echo $row['containment']?></textarea>
                </div>
            </div>

            <div class="section">
                <button type="submit" name="update" class="btn">Update Record</button>
            </div>

        </form>

    </div>

</div>

</div>

</body>
</html>