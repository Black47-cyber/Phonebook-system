<?php
session_start();
include "db.php";

if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Handle add contact
if(isset($_POST['save_contact'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    
    mysqli_query($conn, "INSERT INTO contacts (user_id, name, phone, email, address, notes) 
                        VALUES ('$user_id', '$name', '$phone', '$email', '$address', '$notes')");
    header("Location: dashboard.php");
    exit();
}

// Get contacts
$contacts = mysqli_query($conn, "SELECT * FROM contacts WHERE user_id='$user_id' ORDER BY name ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Phonebook</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="header">
    <h1>📱 Phonebook</h1>
    <div class="user-info">
        <span><?php echo htmlspecialchars($username); ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>My Contacts</h2>
        <button class="btn-primary" onclick="document.getElementById('modal').classList.add('active')" style="width:auto;">
            + Add Contact
        </button>
    </div>

    <div class="search-box">
        🔍 <input type="text" placeholder="Search contacts...">
    </div>

    <?php if(mysqli_num_rows($contacts) == 0): ?>
    <div class="card empty-state">
        <div style="font-size:60px;">📮</div>
        <h3>No contacts yet</h3>
        <p style="color:#6b7280;">Start by adding your first contact</p>
    </div>
    <?php else: ?>
        <?php while($c = mysqli_fetch_assoc($contacts)): ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($c['name']); ?></h3>
            <p>📞 <?php echo htmlspecialchars($c['phone']); ?></p>
            <?php if($c['email']) echo "<p>✉️ ".htmlspecialchars($c['email'])."</p>"; ?>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<!-- Add Contact Modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h3>Add New Contact</h3>
        <form method="post">
            <label>Name *</label>
            <input type="text" name="name" required>
            
            <label>Phone *</label>
            <input type="text" name="phone" required>
            
            <label>Email</label>
            <input type="email" name="email">
            
            <label>Address</label>
            <input type="text" name="address">
            
            <label>Notes</label>
            <textarea name="notes" rows="3" style="width:100%; padding:12px; border:2px solid #e5e7eb; border-radius:8px;"></textarea>
            
            <div class="modal-buttons">
                <button type="button" class="btn-secondary" onclick="document.getElementById('modal').classList.remove('active')">Cancel</button>
                <button type="submit" name="save_contact" class="btn-primary" style="width:auto;">Save Contact</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
