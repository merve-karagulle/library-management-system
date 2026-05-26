<?php
require_once "../config/database.php";
if(isset($_POST["add"])){
  $stmt=$conn->prepare("INSERT INTO users (first_name,last_name,email,phone,birth_date,user_type,status,registration_date) VALUES (?,?,?,?,?,?,?,?)");
  $stmt->bind_param("ssssssss",$_POST["first_name"],$_POST["last_name"],$_POST["email"],$_POST["phone"],$_POST["birth_date"],$_POST["user_type"],$_POST["status"],$_POST["registration_date"]);
  $stmt->execute();
  header("Location: users.php");
}
if(isset($_GET["delete"])){
  $stmt=$conn->prepare("DELETE FROM users WHERE id=?");
  $stmt->bind_param("i",$_GET["delete"]);
  $stmt->execute();
  header("Location: users.php");
}
$users=$conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Users</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><div class="layout">
<aside class="sidebar">
  <div class="logo">Library<span>System</span></div>
  <p class="sidebar-subtitle">PHP & MySQL based library management dashboard.</p>
  <nav class="nav">
    <a class="" href="../index.php">Dashboard <span>⌘</span></a>
    <a class="" href="../pages/books.php">Books <span>→</span></a>
    <a class="active" href="../pages/users.php">Users <span>→</span></a>
    <a class="" href="../pages/loans.php">Loans <span>→</span></a>
  </nav>
  <div class="sidebar-footer">
    <strong>System Status</strong><br>
    Database connected via MySQL. CRUD modules are active.
  </div>
</aside>
<main class="main"><div class="header"><div><h1>Users</h1><p>Manage registered library users.</p></div><a class="btn secondary" href="../index.php">Dashboard</a></div>
<form class="form" method="post">
<input name="first_name" placeholder="First Name" required><input name="last_name" placeholder="Last Name" required>
<input name="email" placeholder="Email"><input name="phone" placeholder="Phone">
<input name="birth_date" type="date"><select name="user_type"><option>Admin</option><option>Normal</option><option>Guest</option></select>
<select name="status"><option>Active</option><option>Passive</option></select><input name="registration_date" type="date">
<button class="btn full" name="add">Add User</button>
</form>
<div class="table-wrap"><table><tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Action</th></tr>
<?php while($row=$users->fetch_assoc()): ?><tr><td><?= $row["id"] ?></td><td><?= htmlspecialchars($row["first_name"]." ".$row["last_name"]) ?></td><td><?= htmlspecialchars($row["email"]) ?></td><td><?= $row["user_type"] ?></td><td><span class="badge <?= $row["status"] === "Active" ? "active" : "passive" ?>"><?= $row["status"] ?></span></td><td><a class="btn danger" href="?delete=<?= $row["id"] ?>">Delete</a></td></tr><?php endwhile; ?>
</table></div></main></div></body></html>
