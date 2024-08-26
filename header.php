<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRS Water System</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.database.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
</head>
<body>

<div class="sidebar">
    <div class="img-logo"></div>
    <p class="logo">GRS Water System</p>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php">
            <span class="icon"> 
                <i class="bi bi-house"></i>
            </span>
            <span class="description">Home</span>
        </a>
        <a class="nav-link" href="consumers.php">
            <span class="icon"> 
                <i class="bi bi-list-ul"></i>
            </span>
            <span class="description">List of Customers</span>
        </a>
        <a class="nav-link" href="addcustomer_form.php">
            <span class="icon">
                <i class="bi bi-person-plus"></i>
            </span>
            <span class="description">Add Consumer</span>
        </a>
        <a class="nav-link" href="consumption_form.php">
            <span class="icon">
                <i class="bi bi-water"></i>
            </span>
            <span class="description">Add Water Reading</span>
        </a>
        <a class="nav-link" href="payment_form.php">
            <span class="icon">
                <i class="bi bi-cash"></i>
            </span>
            <span class="description">Add Payment</span>
        </a>
        <a class="nav-link" href="billingform.php">
            <span class="icon">
                <i class="bi bi-receipt"></i>
            </span>
            <span class="description">Billings</span>
        </a>
        <a class="nav-link" href="pricingrecord.php">
            <span class="icon">
                <i class="bi bi-tags"></i>
            </span>
            <span class="description">Price/Cubic Meter</span>
        </a>
    </nav>
    <nav class="nav-footer">
        <p class="footer-title">&copy;2024 GRS Water System. All Righhts Reserved.</p>
        <p class="footer-title">Developed by: nsacristan</p>
    </nav>
</div>

<!-- Header title start -->
<div class="header-title">
    <div class="header-1">
        <h5>Dashboard</h5>
    </div>
    <div class="header-2">
        <a class="btn btn-primary" href="includes/logout.inc.php" role="button">Log Out</a>
    </div> 
</div>
