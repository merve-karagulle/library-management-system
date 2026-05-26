<?php
require_once "../config/database.php";
if(isset($_POST["add"])){
  $stmt=$conn->prepare("INSERT INTO loans (user_id,book_id,loan_date,return_date,return_status) VALUES (?,?,?,?,?)");
  $stmt->bind_param("iisss",$_POST["user_id"],$_POST["book_id"],$_POST["loan_date"],$_POST["return_date"],$_POST["return_status"]);
  $stmt->execute();
  header("Location: loans.php");
}
if(isset($_GET["delete"])){
  $stmt=$conn->prepare("DELETE FROM loans WHERE id=?");
  $stmt->bind_param("i",$_GET["delete"]);
  $stmt->execute();
  header("Location: loans.php");
}
$users=$conn->query("SELECT id,first_name,last_name FROM users");
$books=$conn->query("SELECT id,title FROM books");
$loans=$conn->query("SELECT loans.*, users.first_name, users.last_name, books.title FROM loans JOIN users ON loans.user_id=users.id JOIN books ON loans.book_id=books.id ORDER BY loans.id DESC");
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Loans</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><div class="layout">
<aside class="sidebar">
  <div class="logo">Library<span>System</span></div>
  <p class="sidebar-subtitle">PHP & MySQL based library management dashboard.</p>
  <nav class="nav">
    <a class="" href="../index.php">Dashboard <span>⌘</span></a>
    <a class="" href="../pages/books.php">Books <span>→</span></a>
    <a class="" href="../pages/users.php">Users <span>→</span></a>
    <a class="active" href="../pages/loans.php">Loans <span>→</span></a>
  </nav>
  <div class="sidebar-footer">
    <strong>System Status</strong><br>
    Database connected via MySQL. CRUD modules are active.
  </div>
</aside>
<main class="main"><div class="header"><div><h1>Loans</h1><p>Track borrowed books and return status.</p></div><a class="btn secondary" href="../index.php">Dashboard</a></div>
<form class="form" method="post">
<select name="user_id" required><?php while($u=$users->fetch_assoc()): ?><option value="<?= $u["id"] ?>"><?= htmlspecialchars($u["first_name"]." ".$u["last_name"]) ?></option><?php endwhile; ?></select>
<select name="book_id" required><?php while($b=$books->fetch_assoc()): ?><option value="<?= $b["id"] ?>"><?= htmlspecialchars($b["title"]) ?></option><?php endwhile; ?></select>
<input name="loan_date" type="date" required><input name="return_date" type="date">
<select name="return_status"><option>Returned</option><option>Not Returned</option></select>
<button class="btn full" name="add">Add Loan Record</button>
</form>
<div class="table-wrap"><table><tr><th>ID</th><th>User</th><th>Book</th><th>Loan Date</th><th>Return Date</th><th>Status</th><th>Action</th></tr>
<?php while($row=$loans->fetch_assoc()): ?><tr><td><?= $row["id"] ?></td><td><?= htmlspecialchars($row["first_name"]." ".$row["last_name"]) ?></td><td><?= htmlspecialchars($row["title"]) ?></td><td><?= $row["loan_date"] ?></td><td><?= $row["return_date"] ?></td><td><span class="badge <?= $row["return_status"] === "Returned" ? "returned" : "notreturned" ?>"><?= $row["return_status"] ?></span></td><td><a class="btn danger" href="?delete=<?= $row["id"] ?>">Delete</a></td></tr><?php endwhile; ?>
</table></div></main></div></body></html>
