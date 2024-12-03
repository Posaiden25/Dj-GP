CREATE DATABASE KaraokeDB;
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
  contributer_type VARCHAR(255)
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
    q_type INT NOT NULL,
    user_id INT,
    song_id INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (song_id) REFERENCES Song(song_id)
);

INSERT INTO User(name, email) VALUES
('Alice', 'alice@example.com'),
('Bob', 'bob@example.com'),
('Charlie', 'charlie@example.com'),
('Dave', 'dave@example.com'),
('Eve', 'eve@example.com'),
('Frank', 'frank@example.com'),
('Grace', 'grace@example.com'),
('Hank', 'hank@example.com'),
('Ivy', 'ivy@example.com'),
('Jack', 'jack@example.com');

INSERT INTO Artist(artist_name) VALUES
('The Weeknd'),
('Mark Ronson'),
('Bruno Mars'),
('Ed Sheeran'),
('Adele'),
('Queen'),
('Lady Gaga'),
('Bradley Cooper'),
('Lil Nas X'),
('Billy Ray Cyrus'),
('Luis Fonsi'),
('Daddy Yankee'),
('Pharrell Williams'),
('BTS'),
('Billie Eilish'),
('Taylor Swift'),
('Bee Gees'),
('Harry Styles'),
('Dua Lipa'),
('Post Malone'),
('Shakira'),
('John Legend'),
('Carly Rae Jepsen'),
('Imagine Dragons'),
('Shawn Mendes'),
('Camila Cabello'),
('Neil Diamond'),
('Journey');


INSERT INTO Song (title, genre, karaoke_file, artist_id) VALUES
('Blinding Lights', 'Pop', 'blinding_lights.kar', 1),
('Uptown Funk', 'Funk', 'uptown_funk.kar', 2),
('Shape of You', 'Pop', 'shape_of_you.kar', 3),
('Rolling in the Deep', 'Pop', 'rolling_in_the_deep.kar', 4),
('Bohemian Rhapsody', 'Rock', 'bohemian_rhapsody.kar', 5),
('Shallow', 'Pop', 'shallow.kar', 6),
('Old Town Road', 'Country', 'old_town_road.kar', 7),
('Someone Like You', 'Pop', 'someone_like_you.kar', 4),
('Despacito', 'Reggaeton', 'despacito.kar', 8),
('Happy', 'Pop', 'happy.kar', 9),
('Dynamite', 'Pop', 'dynamite.kar', 10),
('Bad Guy', 'Pop', 'bad_guy.kar', 11),
('Thinking Out Loud', 'Pop', 'thinking_out_loud.kar', 3),
('Shake It Off', 'Pop', 'shake_it_off.kar', 12),
('Hello', 'Pop', 'hello.kar', 4),
('Stayin Alive', 'Disco', 'stayin_alive.kar', 13),
('Watermelon Sugar', 'Pop', 'watermelon_sugar.kar', 14),
('Levitating', 'Pop', 'levitating.kar', 15),
('Sunflower', 'Pop', 'sunflower.kar', 16),
('Waka Waka', 'Pop', 'waka_waka.kar', 17),
('All of Me', 'Pop', 'all_of_me.kar', 18),
('Call Me Maybe', 'Pop', 'call_me_maybe.kar', 19),
('Believer', 'Rock', 'believer.kar', 20),
('Señorita', 'Pop', 'senorita.kar', 21),
('Radioactive', 'Rock', 'radioactive.kar', 20),
('Closer', 'Pop', 'closer.kar', 22),
('Havana', 'Pop', 'havana.kar', 23),
('We Will Rock You', 'Rock', 'we_will_rock_you.kar', 5),
('Sweet Caroline', 'Pop', 'sweet_caroline.kar', 24),
('Don''t Stop Believin''', 'Rock', 'dont_stop_believin.kar', 25);

INSERT INTO Contributor(name, contributor_type) VALUES
('Max Martin', 'Producer'),
('Pharrell Williams', 'Producer'),
('Ed Sheeran', 'Songwriter'),
('Ryan Tedder', 'Songwriter'),
('David Guetta', 'Producer'),
('Sia', 'Songwriter');

INSERT INTO SongArtist (song_id, artist_id) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(6, 8),
(7, 9),
(7, 10),
(8, 11),
(9, 12),
(9, 13),
(10, 14),
(11, 15),
(12, 16),
(13, 17),
(14, 18),
(15, 19),
(16, 20),
(17, 21),
(18, 22),
(19, 23),
(20, 24),
(21, 25),
(22, 26);

INSERT INTO SongContributor (song_id, contributor_id) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(6, 8),
(7, 9),
(7, 10),
(8, 11),
(9, 12),
(9, 13),
(10, 14),
(11, 15),
(12, 16),
(13, 17),
(14, 18),
(15, 19),
(16, 20),
(17, 21),
(18, 22),
(19, 23),
(20, 24),
(21, 25),
(22, 26),
(23, 27),
(24, 28),
(25, 29),
(26, 30),
(27, 31),
(28, 32),
(29, 33),
(30, 34);

INSERT INTO Queue (q_type, user_id, song_id) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 3),
(1, 4, 4),
(2, 5, 5),
(1, 6, 6),
(2, 7, 7),
(1, 8, 8),
(1, 9, 9),
(2, 10, 10),
(1, 11, 11),
(2, 12, 12),
(1, 13, 13),
(2, 14, 14),
(1, 15, 15);
