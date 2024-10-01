<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db.php');

// Handle form submission for adding property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_property'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);

    $query = "INSERT INTO properties (name, address, units) VALUES ('$name', '$address', '$units')";
    if (mysqli_query($conn, $query)) {
        $message = "Property added successfully!";
    } else {
        $message = "Error adding property!";
    }
}

// Fetch properties for display
$properties = mysqli_query($conn, "SELECT * FROM properties");
?>

<?php include('../includes/header.php') ?>
<div class="container mt-5">
    <h1 class="mb-4">Manage Properties</h1>
    
    <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">Property Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="units" class="form-label">Number of Units</label>
            <input type="number" class="form-control" id="units" name="units" required>
        </div>
        <button type="submit" name="add_property" class="btn btn-primary">Add Property</button>
    </form>

    <h2>All Properties</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Address</th>
                <th>Units</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($properties)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['units']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php') ?>
