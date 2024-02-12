<h2>What is Vocab Tracker?</h2>
<b>VocabTracker</b> is a simple PHP+MySQL application leveraging on CRUD operations. 

For every new vocabulary that I come to learn of once in a blue moon, it would be nice to store it in an online platform that allows me to focus on learning and reviewing the terms, and not just refer to the Notes App which stores everything else (it's kind of messy). So I decided to make this vocabulary tracker application designed for this sole purpose!

<h2>How to start?</h2>
1. Set up your database in your SQL server.

```
CREATE DATABASE vocab;

CREATE USER '[any user name]'@'localhost' IDENTIFIED BY '[any password]';
GRANT ALL ON vocab.* TO '[above user name]'@'localhost';
CREATE USER '[above user name]'@'127.0.0.1' IDENTIFIED BY '[above password]';
GRANT ALL ON vocab.* TO '[above user name]'@'127.0.0.1';
```

2. Set up connection to database and create table. See [connection.php](https://github.com/phyosandarwin/vocab_tracker/blob/1aa376d7556ecb6bbb82018e883cb9ef557b6083/src/connection.php) on how to do this. *For Windows, the port number is 3306.*

```
USE entries; 
CREATE TABLE IF NOT EXISTS entries (
  entry_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  word VARCHAR(255),
  entry_date DATE,
  meaning TEXT,
  sentence TEXT
)
```

3. Clone the repository or download the files locally into your ```xampp/htdocs``` folder.

4. Launch the application via localhost


<h2>Video Demo on navigating application</h2>
[![Vocab Tracker PHP application](https://img.youtube.com/vi/7pR9-xiqucs/0.jpg)](https://www.youtube.com/watch?v=7pR9-xiqucs)
