<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db.php');

// Handle form submission for recording rent payment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_payment'])) {
    $tenant_id = mysqli_real_escape_string($conn, $_POST['tenant_id']);
    $amount_paid = mysqli_real_escape_string($conn, $_POST['amount_paid']);
    $status = ($amount_paid > 0) ? 'paid' : 'overdue'; // You can adjust this logic

    $query = "INSERT INTO rent_payments (tenant_id, amount_paid, payment_date, status) VALUES ('$tenant_id', '$amount_paid', NOW(), '$status')";
    if (mysqli_query($conn, $query)) {
        $message = "Rent payment recorded successfully!";
    } else {
        $message = "Error recording rent payment!";
    }
}

// Fetch rent payments and tenants for display
$payments = mysqli_query($conn, "SELECT rent_payments.*, tenants.name as tenant_name FROM rent_payments JOIN tenants ON rent_payments.tenant_id = tenants.id");
$tenants = mysqli_query($conn, "SELECT * FROM tenants");
?>

<?php include('../includes/header.php') ?>
<div class="container mt-5">
    <h1 class="mb-4">Rent Tracking</h1>

    <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="tenant_id" class="form-label">Select Tenant</label>
            <select class="form-select" id="tenant_id" name="tenant_id" required>
                <option value="">Choose a tenant...</option>
                <?php while ($tenant = mysqli_fetch_assoc($tenants)) { ?>
                    <option value="<?php echo $tenant['id']; ?>"><?php echo $tenant['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <input type="number" class="form-control" id="amount_paid" name="amount_paid" required>
        </div>
        <button type="submit" name="record_payment" class="btn btn-primary">Record Payment</button>
    </form>

    <h2>All Rent Payments</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tenant Name</th>
                <th>Amount Paid</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($payments)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tenant_name']; ?></td>
                <td><?php echo $row['amount_paid']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
                <td class="<?php echo ($row['status'] == 'overdue') ? 'text-danger' : 'text-success'; ?>">
                    <?php echo ucfirst($row['status']); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php') ?>
