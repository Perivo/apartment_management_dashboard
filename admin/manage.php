<?php
session_start();
include('../includes/db.php');

// Handle Delete Operation
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $table = $_GET['table'];
    $id = $_GET['id'];

    $deleteQuery = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Entry deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting entry: " . $stmt->error;
    }
    header("Location: manage.php");
    exit();
}

// Handle Approval/Completion Operation
if (isset($_GET['action']) && $_GET['action'] == 'approve') {
    $table = $_GET['table'];
    $id = $_GET['id'];

    // Approve Maintenance Requests or mark Rent as done
    if ($table == 'maintenance_requests') {
        $updateQuery = "UPDATE maintenance_requests SET status = 'completed' WHERE id = ?";
    } elseif ($table == 'rent_payments') {
        $updateQuery = "UPDATE rent_payments SET status = 'paid' WHERE id = ?";
    }

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Entry updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating entry: " . $stmt->error;
    }
    header("Location: manage.php");
    exit();
}

// Fetch All Data
$properties = $conn->query("SELECT * FROM properties");
$tenants = $conn->query("SELECT * FROM tenants");
$maintenance_requests = $conn->query("SELECT * FROM maintenance_requests");
$rent_payments = $conn->query("SELECT * FROM rent_payments");

?>
 
 <?php include('../includes/header.php') ?>
<div class="container">
    <h2>Manage Entries</h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <h4>Properties</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Name</th>
                <th>Address</th>
                <th>Units</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($property = $properties->fetch_assoc()): ?>
                <tr>
                    <td><?= $property['id']; ?></td>
                    <td><?= $property['name']; ?></td>
                    <td><?= $property['address']; ?></td>
                    <td><?= $property['units']; ?></td>
                    <td>
                        <a href="?action=delete&table=properties&id=<?= $property['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Tenants</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Lease Start</th>
                <th>Rent Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tenant = $tenants->fetch_assoc()): ?>
                <tr>
                    <td><?= $tenant['id']; ?></td>
                    <td><?= $tenant['property_id']; ?></td>
                    <td><?= $tenant['name']; ?></td>
                    <td><?= $tenant['contact']; ?></td>
                    <td><?= $tenant['lease_start']; ?></td>
                    <td><?= $tenant['rent_amount']; ?></td>
                    <td>
                        <a href="?action=delete&table=tenants&id=<?= $tenant['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Maintenance Requests</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property ID</th>
                <th>Description</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($request = $maintenance_requests->fetch_assoc()): ?>
                <tr>
                    <td><?= $request['id']; ?></td>
                    <td><?= $request['property_id']; ?></td>
                    <td><?= $request['description']; ?></td>
                    <td><?= $request['status']; ?></td>
                    <td><?= $request['request_date']; ?></td>
                    <td>
                        <?php if ($request['status'] !== 'completed'): ?>
                            <a href="?action=approve&table=maintenance_requests&id=<?= $request['id']; ?>" class="btn btn-success btn-sm">Mark as Done</a>
                        <?php endif; ?>
                        <a href="?action=delete&table=maintenance_requests&id=<?= $request['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Rent Payments</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tenant ID</th>
                <th>Amount Paid</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($payment = $rent_payments->fetch_assoc()): ?>
                <tr>
                    <td><?= $payment['id']; ?></td>
                    <td><?= $payment['tenant_id']; ?></td>
                    <td><?= $payment['amount_paid']; ?></td>
                    <td><?= $payment['payment_date']; ?></td>
                    <td><?= $payment['status']; ?></td>
                    <td>
                        <?php if ($payment['status'] !== 'paid'): ?>
                            <a href="?action=approve&table=rent_payments&id=<?= $payment['id']; ?>" class="btn btn-success btn-sm">Mark as Paid</a>
                        <?php endif; ?>
                        <a href="?action=delete&table=rent_payments&id=<?= $payment['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php') ?>