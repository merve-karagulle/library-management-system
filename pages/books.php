<?php
require_once "../config/database.php";
if(isset($_POST["add"])){
  $stmt=$conn->prepare("INSERT INTO books (title,author,category,page_count,publication_year,isbn,publisher) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param("sssiiss",$_POST["title"],$_POST["author"],$_POST["category"],$_POST["page_count"],$_POST["publication_year"],$_POST["isbn"],$_POST["publisher"]);
  $stmt->execute();
  header("Location: books.php");
}
if(isset($_GET["delete"])){
  $stmt=$conn->prepare("DELETE FROM books WHERE id=?");
  $stmt->bind_param("i",$_GET["delete"]);
  $stmt->execute();
  header("Location: books.php");
}
$books=$conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Books</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body><div class="layout">
<aside class="sidebar">
  <div class="logo">Library<span>System</span></div>
  <p class="sidebar-subtitle">PHP & MySQL based library management dashboard.</p>
  <nav class="nav">
    <a class="" href="../index.php">Dashboard <span>⌘</span></a>
    <a class="active" href="../pages/books.php">Books <span>→</span></a>
    <a class="" href="../pages/users.php">Users <span>→</span></a>
    <a class="" href="../pages/loans.php">Loans <span>→</span></a>
  </nav>
  <div class="sidebar-footer">
    <strong>System Status</strong><br>
    Database connected via MySQL. CRUD modules are active.
  </div>
</aside>
<main class="main"><div class="header"><div><h1>Books</h1><p>Add, list and delete book records.</p></div><a class="btn secondary" href="../index.php">Dashboard</a></div>
<form class="form" method="post">
<input name="title" placeholder="Book Title" required><input name="author" placeholder="Author" required>
<input name="category" placeholder="Category"><input name="page_count" type="number" placeholder="Page Count">
<input name="publication_year" type="number" placeholder="Publication Year"><input name="isbn" placeholder="ISBN">
<input class="full" name="publisher" placeholder="Publisher"><button class="btn full" name="add">Add Book</button>
</form>
<div class="table-wrap"><table><tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Year</th><th>Action</th></tr>
<?php while($row=$books->fetch_assoc()): ?><tr><td><?= $row["id"] ?></td><td><?= htmlspecialchars($row["title"]) ?></td><td><?= htmlspecialchars($row["author"]) ?></td><td><?= htmlspecialchars($row["category"]) ?></td><td><?= $row["publication_year"] ?></td><td><a class="btn danger" href="?delete=<?= $row["id"] ?>">Delete</a></td></tr><?php endwhile; ?>
</table></div></main></div></body></html>
