CREATE DATABASE IF NOT EXISTS KaraokeDB;
USE KaraokeDB;

CREATE TABLE User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255)
);

CREATE TABLE Artist(
  artist_id INT AUTO_INCREMENT PRIMARY KEY,
  artist_name VARCHAR(255) NOT NULL
);

CREATE TABLE Contributor(
  contributor_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  contributor_type VARCHAR(255)
);

CREATE TABLE Song (
    song_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    band VARCHAR(255) DEFAULT 'N/A',
    genre VARCHAR(50) NOT NULL,
    artist_id INT,
    karaoke_file VARCHAR(50),

    FOREIGN KEY (artist_id) REFERENCES Artist(artist_id)
);

CREATE TABLE SongArtist (
    song_id INT,
    artist_id INT,
    PRIMARY KEY (song_id, artist_id),
    FOREIGN KEY (song_id) REFERENCES Song(song_id),
    FOREIGN KEY (artist_id) REFERENCES Artist(artist_id)
);

CREATE TABLE SongContributor (
    song_id INT,
    contributor_id INT,
    PRIMARY KEY (song_id, contributor_id),
    FOREIGN KEY (song_id) REFERENCES Song(song_id),
    FOREIGN KEY (contributor_id) REFERENCES Contributor(contributor_id)
);

CREATE TABLE Queue (
    q_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    song_id INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (song_id) REFERENCES Song(song_id)
);

CREATE TABLE PriorityQueue (
    pq_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    song_id INT,
    money INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (song_id) REFERENCES Song(song_id)
);
