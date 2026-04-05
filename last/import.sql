use mcq_test;
CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  subject VARCHAR(255),
  question TEXT,
  option_a TEXT,
  option_b TEXT,
  option_c TEXT,
  option_d TEXT,
  correct_answer VARCHAR(1)
);
