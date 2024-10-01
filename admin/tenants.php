<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db.php');

// Handle form submission for adding tenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_tenant'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $lease_start = mysqli_real_escape_string($conn, $_POST['lease_start']);
    $rent_amount = mysqli_real_escape_string($conn, $_POST['rent_amount']);
    $property_id = mysqli_real_escape_string($conn, $_POST['property_id']);

    $query = "INSERT INTO tenants (name, contact, lease_start, rent_amount, property_id) 
              VALUES ('$name', '$contact', '$lease_start', '$rent_amount', '$property_id')";
    if (mysqli_query($conn, $query)) {
        $message = "Tenant added successfully!";
    } else {
        $message = "Error adding tenant!";
    }
}

// Fetch tenants and properties for display
$tenants = mysqli_query($conn, "SELECT tenants.*, properties.name as property_name FROM tenants JOIN properties ON tenants.property_id = properties.id");
$properties = mysqli_query($conn, "SELECT * FROM properties");
?>

<?php include('../includes/header.php') ?>
<div class="container mt-5">
    <h1 class="mb-4">Manage Tenants</h1>

    <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">Tenant Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
        </div>
        <div class="mb-3">
            <label for="lease_start" class="form-label">Lease Start Date</label>
            <input type="date" class="form-control" id="lease_start" name
            <label for="lease_start" class="form-label">Lease Start Date</label>
            <input type="date" class="form-control" id="lease_start" name="lease_start" required>
        </div>
        <div class="mb-3">
            <label for="rent_amount" class="form-label">Rent Amount</label>
            <input type="number" class="form-control" id="rent_amount" name="rent_amount" required>
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
        <button type="submit" name="add_tenant" class="btn btn-primary">Add Tenant</button>
    </form>

    <h2>All Tenants</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Lease Start</th>
                <th>Rent Amount</th>
                <th>Property</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($tenants)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['lease_start']; ?></td>
                <td><?php echo $row['rent_amount']; ?></td>
                <td><?php echo $row['property_name']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php') ?>
