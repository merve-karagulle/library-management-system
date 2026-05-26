<?php
require_once "config/database.php";
$bookCount = $conn->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()["total"];
$userCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()["total"];
$loanCount = $conn->query("SELECT COUNT(*) AS total FROM loans")->fetch_assoc()["total"];
$activeLoanCount = $conn->query("SELECT COUNT(*) AS total FROM loans WHERE return_status='Not Returned'")->fetch_assoc()["total"];
$recentBooks = $conn->query("SELECT * FROM books ORDER BY id DESC LIMIT 5");
$recentLoans = $conn->query("SELECT loans.*, users.first_name, users.last_name, books.title FROM loans JOIN users ON loans.user_id=users.id JOIN books ON loans.book_id=books.id ORDER BY loans.id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Library Management System</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
  <div class="logo">Library<span>System</span></div>
  <p class="sidebar-subtitle">PHP & MySQL based library management dashboard.</p>
  <nav class="nav">
    <a class="active" href="index.php">Dashboard <span>⌘</span></a>
    <a class="" href="pages/books.php">Books <span>→</span></a>
    <a class="" href="pages/users.php">Users <span>→</span></a>
    <a class="" href="pages/loans.php">Loans <span>→</span></a>
  </nav>
  <div class="sidebar-footer">
    <strong>System Status</strong><br>
    Database connected via MySQL. CRUD modules are active.
  </div>
</aside>
  <main class="main">
    <div class="header">
      <div>
        <h1>Library Dashboard</h1>
        <p>Manage books, users and loan tracking records from one modern admin panel.</p>
      </div>
      <a class="btn secondary" href="pages/books.php">Manage Books</a>
    </div>

    <section class="cards">
      <div class="card blue"><h3>Total Books</h3><strong><?= $bookCount ?></strong><small>Registered books</small></div>
      <div class="card green"><h3>Total Users</h3><strong><?= $userCount ?></strong><small>Library members</small></div>
      <div class="card orange"><h3>Total Loans</h3><strong><?= $loanCount ?></strong><small>Borrowing records</small></div>
      <div class="card purple"><h3>Active Loans</h3><strong><?= $activeLoanCount ?></strong><small>Not returned yet</small></div>
    </section>

    <section class="grid-two">
      <div class="table-wrap">
        <h2>Recent Books</h2>
        <table>
          <tr><th>Book</th><th>Author</th><th>Category</th><th>Year</th></tr>
          <?php while($row=$recentBooks->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row["title"]) ?></td>
            <td><?= htmlspecialchars($row["author"]) ?></td>
            <td><?= htmlspecialchars($row["category"]) ?></td>
            <td><?= htmlspecialchars($row["publication_year"]) ?></td>
          </tr>
          <?php endwhile; ?>
        </table>
      </div>

      <div class="panel">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
          <a href="pages/books.php">Add or manage books <span>+</span></a>
          <a href="pages/users.php">Register library users <span>+</span></a>
          <a href="pages/loans.php">Track borrowed books <span>+</span></a>
        </div>
      </div>
    </section>

    <br>

    <div class="table-wrap">
      <h2>Recent Loan Records</h2>
      <table>
        <tr><th>User</th><th>Book</th><th>Loan Date</th><th>Return Date</th><th>Status</th></tr>
        <?php while($row=$recentLoans->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row["first_name"]." ".$row["last_name"]) ?></td>
          <td><?= htmlspecialchars($row["title"]) ?></td>
          <td><?= htmlspecialchars($row["loan_date"]) ?></td>
          <td><?= htmlspecialchars($row["return_date"]) ?></td>
          <td><span class="badge <?= $row["return_status"] === "Returned" ? "returned" : "notreturned" ?>"><?= htmlspecialchars($row["return_status"]) ?></span></td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </main>
</div>
</body>
</html>
