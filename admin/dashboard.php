<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db.php');

// Fetch data for the dashboard
$total_properties = mysqli_query($conn, "SELECT COUNT(*) as count FROM properties");
$total_tenants = mysqli_query($conn, "SELECT COUNT(*) as count FROM tenants");
$pending_requests = mysqli_query($conn, "SELECT COUNT(*) as count FROM maintenance_requests WHERE status = 'pending'");
$overdue_rent = mysqli_query($conn, "SELECT COUNT(*) as count FROM rent_payments WHERE status = 'overdue'");

$total_properties = mysqli_fetch_assoc($total_properties)['count'];
$total_tenants = mysqli_fetch_assoc($total_tenants)['count'];
$pending_requests = mysqli_fetch_assoc($pending_requests)['count'];
$overdue_rent = mysqli_fetch_assoc($overdue_rent)['count'];
?>

<?php include('../includes/header.php') ?>
<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Properties</h5>
                    <p class="card-text"><?php echo $total_properties; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tenants</h5>
                    <p class="card-text"><?php echo $total_tenants; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pending Maintenance</h5>
                    <p class="card-text"><?php echo $pending_requests; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Overdue Rent</h5>
                    <p class="card-text"><?php echo $overdue_rent; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/footer.php') ?>
