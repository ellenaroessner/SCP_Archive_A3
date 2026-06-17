<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCP Foundation</title>

    <link rel="stylesheet" href="scp_detective_archive.css">
</head>

<body>

<div class="container">

<?php 
    include "connection.php"; 
?>

<!-- TOP BAR -->
<div class="topbar">
    <div class="logo-box">SCP ARCHIVE</div>

    <div class="topbar-right">
        <div class="access-level">FIELD TERMINAL ACCESS</div>
    </div>
</div>

<!-- MAIN GRID -->
<div class="main-grid">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <!-- SYSTEM STATUS -->
        <div class="sidebar-block">
            <div class="sidebar-label">System Status</div>

            <div class="meta-row">
                <div class="meta-key">Connection</div>
                <div class="meta-text-values green">ONLINE</div>
            </div>

            <div class="meta-row">
                <div class="meta-key">Security</div>
                <div class="meta-text-values amber">LEVEL 3</div>
            </div>
        </div>

        <!-- CREATE NEW ENTRY -->
        <div class="sidebar-block">
            <div class="sidebar-label">Create New Entry</div>
            <a href="create.php" class="btn">+ Create Entry</a>
        </div>

        <!-- SCP INDEX -->
        <div class="sidebar-block">
            <div class="sidebar-label">SCP Index</div>

            <div class="meta-row">
                <div class="meta-text-values scp-index-list">

<?php
$result = $connection->query("SELECT id, subject, item FROM scp_entries");

if ($result && $result->num_rows > 0) {

    echo "<ul class='scp-list'>";

    foreach($result as $link) {

        echo "
            <li class='scp-list-item'>
                <a href='index.php?scp={$link['id']}'>
                    {$link['subject']}
                </a>
            </li>
        ";
    }

    echo "</ul>";

} else {
    echo "No SCP entries found.";
}
?>

                </div>
            </div>
        </div>

    </div>

    <!-- CONTENT PANE -->
    <div class="content-pane">

        <div class="content-header">
            <div class="item-id">SCP ARCHIVE</div>
            <div class="item-subtitle">DATABASE INTERFACE</div>
        </div>

<?php 

// If an SCP entry is selected
if(isset($_GET['scp']))
{
    $id = $_GET['scp'];

    $stmt = $connection->prepare("SELECT * FROM scp_entries WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute())
    {
        $record = $stmt->get_result();
        $array = $record->fetch_assoc();

        if ($array) {

            $update = "update.php?update=".$array['id'];
            $delete = "index.php?delete=".$array['id'];

            echo "

                <div class='section'>
                    <div class='section-tag'>Subject</div>
                    <div class='section-body'>{$array['subject']}</div>
                </div>

                <div class='section'>
                    <div class='section-tag'>Item #</div>
                    <div class='section-body'>{$array['item']}</div>
                </div>

                <div class='section'>
                    <div class='section-tag'>Object Class</div>
                    <div class='section-body'>{$array['class']}</div>
                </div>

                <div class='section'>
                    <div class='section-tag'>Image</div>
                    <div class='section-body'>
                        <div class='img-box'>
                            <img src='{$array['image']}' alt='{$array['subject']}'>
                        </div>
                    </div>
                </div>

                <div class='section'>
                    <div class='section-tag'>Description</div>
                    <div class='section-body'>{$array['description']}</div>
                </div>

                <div class='section'>
                    <div class='section-tag'>Containment Procedures</div>
                    <div class='section-body'>{$array['containment']}</div>
                </div>

                <div class='section'>
                    <a href='{$update}' class='btn'>Update Record</a>
                    <a href='{$delete}' class='btn'>Delete Record</a>
                </div>

            ";
        }
        else {
            echo "<div class='section'><div class='section-body'>No record found.</div></div>";
        }
    }
}
else
{
    echo "
        <div class='section'>
            <div class='section-tag'>Welcome</div>
            <div class='section-body'>
                Select an SCP entry from the index to view its file.
            </div>
        </div>
    ";
}

// delete record
if(isset($_GET['delete']))
{
    $delID = $_GET['delete'];
    $delete = $connection->prepare("DELETE FROM scp_entries WHERE id=?");
    $delete->bind_param("i", $delID);

    if($delete->execute())
    {
        echo "<div class='section'>
                <div class='section-body'>RECORD SUCCESSFULLY DELETED</div>
                <a href='index.php' class='btn'>Back to Homepage</a>
              </div>";
    }
    else
    {
        echo "<div class='section'>
                <div class='section-body'>Error: {$delete->error}</div>
                <a href='index.php' class='btn'>Back to Homepage</a>
              </div>";
    }
}

?>

    </div>
</div>

</div>

</body>
</html>