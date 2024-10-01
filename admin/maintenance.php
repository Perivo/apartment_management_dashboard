<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db.php');

// Handle form submission for adding maintenance request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_request'])) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $property_id = mysqli_real_escape_string($conn, $_POST['property_id']);

    $query = "INSERT INTO maintenance_requests (description, property_id, request_date) VALUES ('$description', '$property_id', NOW())";
    if (mysqli_query($conn, $query)) {
        $message = "Maintenance request added successfully!";
    } else {
        $message = "Error adding maintenance request!";
    }
}

// Fetch maintenance requests for display
$requests = mysqli_query($conn, "SELECT maintenance_requests.*, properties.name as property_name FROM maintenance_requests JOIN properties ON maintenance_requests.property_id = properties.id");
$properties = mysqli_query($conn, "SELECT * FROM properties");
?>

<?php include('../includes/header.php') ?>
<div class="container mt-5">
    <h1 class="mb-4">Manage Maintenance Requests</h1>

    <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="property_id" class="form-label">Select Property</label>
            <select class="form-select" id="property_id" name="property_id" required>
                <option value="">Choose a property...</option>
                <?php while ($property = mysqli_fetch_assoc($properties)) { ?>
                    <option value="<?php echo $property['id']; ?>"><?php echo $property['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="add_request" class="btn btn-primary">Add Request</button>
    </form>

    <h2>All Maintenance Requests</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Property</th>
                <th>Status</th>
                <th>Request Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($requests)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['property_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['request_date']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php') ?>
