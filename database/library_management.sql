DROP TABLE IF EXISTS loans;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS books;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    category VARCHAR(80),
    page_count INT,
    publication_year INT,
    isbn VARCHAR(50),
    publisher VARCHAR(120),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(120),
    phone VARCHAR(30),
    birth_date DATE,
    user_type ENUM('Admin', 'Normal', 'Guest') DEFAULT 'Normal',
    status ENUM('Active', 'Passive') DEFAULT 'Active',
    registration_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    loan_date DATE NOT NULL,
    return_date DATE,
    return_status ENUM('Returned', 'Not Returned') DEFAULT 'Not Returned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

INSERT INTO books (title, author, category, page_count, publication_year, isbn, publisher) VALUES
('Clean Code', 'Robert C. Martin', 'Software Engineering', 464, 2008, '9780132350884', 'Prentice Hall'),
('Introduction to Algorithms', 'Thomas H. Cormen', 'Algorithms', 1312, 2009, '9780262033848', 'MIT Press'),
('Artificial Intelligence: A Modern Approach', 'Stuart Russell', 'Artificial Intelligence', 1136, 2020, '9780134610993', 'Pearson'),
('Design Patterns', 'Erich Gamma', 'Software Design', 395, 1994, '9780201633610', 'Addison-Wesley'),
('The Pragmatic Programmer', 'Andrew Hunt', 'Software Engineering', 352, 2019, '9780135957059', 'Addison-Wesley');

INSERT INTO users (first_name, last_name, email, phone, birth_date, user_type, status, registration_date) VALUES
('Merve', 'Karagülle', 'mervekrgll44@icloud.com', '5000000000', '2004-01-01', 'Admin', 'Active', CURDATE()),
('Ayşe', 'Yılmaz', 'ayse@example.com', '5551112233', '2002-03-12', 'Normal', 'Active', CURDATE()),
('Mehmet', 'Demir', 'mehmet@example.com', '5552223344', '2001-07-22', 'Normal', 'Active', CURDATE()),
('Zeynep', 'Kaya', 'zeynep@example.com', '5553334455', '2003-11-04', 'Guest', 'Passive', CURDATE());

INSERT INTO loans (user_id, book_id, loan_date, return_date, return_status) VALUES
(1, 1, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'Not Returned'),
(2, 3, DATE_SUB(CURDATE(), INTERVAL 5 DAY), DATE_ADD(CURDATE(), INTERVAL 9 DAY), 'Not Returned'),
(3, 2, DATE_SUB(CURDATE(), INTERVAL 20 DAY), DATE_SUB(CURDATE(), INTERVAL 4 DAY), 'Returned');
