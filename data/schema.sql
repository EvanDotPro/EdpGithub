CREATE TABLE edpgithub_user
(
  user_id   INTEGER NOT NULL,
  github_id INTEGER NOT NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY (github_id),
  FOREIGN KEY (user_id) REFERENCES user (user_id)
) ENGINE=InnoDB;
