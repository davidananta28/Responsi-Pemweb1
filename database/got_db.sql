-- =========================================================
-- DATABASE: got_db
-- Game of Thrones Web Project
-- Import file ini lewat phpMyAdmin (XAMPP/Laragon) sebelum
-- menjalankan aplikasi.
-- =========================================================

CREATE DATABASE IF NOT EXISTS got_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE got_db;

-- ---------------------------------------------------------
-- Tabel: users
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama_lengkap VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    foto_profil VARCHAR(255) NOT NULL DEFAULT 'profile.png',
    gelar VARCHAR(100) DEFAULT '',
    kutipan VARCHAR(255) DEFAULT '',
    id_faksi INT(11) DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabel: faksi (House / Great Houses)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS faksi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama_faksi VARCHAR(100) NOT NULL,
    motto VARCHAR(255) DEFAULT '',
    wilayah VARCHAR(100) DEFAULT '',
    senjata VARCHAR(100) DEFAULT '',
    deskripsi TEXT,
    poster VARCHAR(255) DEFAULT 'placeholder.jpg',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabel: film (Season / Series)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS film (
    id INT(11) NOT NULL AUTO_INCREMENT,
    judul VARCHAR(150) NOT NULL,
    kategori VARCHAR(50) DEFAULT 'TV Series',
    durasi VARCHAR(50) DEFAULT '',
    tahun INT(11) DEFAULT 0,
    rating VARCHAR(10) DEFAULT 'N/A',
    peringatan VARCHAR(255) DEFAULT '',
    pemeran TEXT,
    genre VARCHAR(255) DEFAULT '',
    tags VARCHAR(255) DEFAULT '',
    sinopsis TEXT,
    poster VARCHAR(255) DEFAULT 'placeholder.jpg',
    banner_hero VARCHAR(255) DEFAULT 'placeholder.jpg',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabel: episode
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS episode (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_film INT(11) NOT NULL,
    eps_num INT(11) NOT NULL DEFAULT 1,
    durasi VARCHAR(50) DEFAULT '',
    judul_eps VARCHAR(150) NOT NULL,
    video_url VARCHAR(255) DEFAULT '',
    thumbnail VARCHAR(255) DEFAULT 'placeholder.jpg',
    deskripsi TEXT,
    PRIMARY KEY (id),
    KEY id_film (id_film),
    CONSTRAINT fk_episode_film FOREIGN KEY (id_film) REFERENCES film (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabel: anggota_faksi (Karakter / Member House)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS anggota_faksi (
    id INT(11) NOT NULL AUTO_INCREMENT,
    id_faksi INT(11) DEFAULT 0,
    nama_karakter VARCHAR(100) NOT NULL,
    gelar VARCHAR(150) DEFAULT '',
    foto_karakter VARCHAR(255) DEFAULT 'placeholder.jpg',
    bio TEXT,
    PRIMARY KEY (id),
    KEY id_faksi (id_faksi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- SEED DATA
-- =========================================================

-- Admin default (username: admin / password: admin123)
INSERT INTO users (nama_lengkap, username, email, password, role, gelar, kutipan, id_faksi) VALUES
('Hand of the King', 'admin', 'admin@westeros.com', '$2y$10$7VYMQCgee6lzPmqkj9jgMeNCVRpapP/kmCBH/vKJb8kW69ghDWQmu', 'admin', 'Hand of the King', 'Winter is Coming', 0);

-- Faksi / Great Houses
INSERT INTO faksi (nama_faksi, motto, wilayah, senjata, deskripsi, poster) VALUES
('House Stark', 'Winter is Coming', 'The North', 'Ice (Greatsword)', 'House Stark adalah salah satu Great House tertua di Westeros, menguasai wilayah The North dari benteng kuno mereka, Winterfell. Dikenal karena kehormatan dan kesetiaan terhadap nilai-nilai kuno.', 'stark.png'),
('House Lannister', 'Hear Me Roar', 'The Westerlands', 'Brightroar', 'House Lannister adalah salah satu keluarga paling kaya di Tujuh Kerajaan, menguasai The Westerlands dengan tambang emas yang melimpah dari Casterly Rock.', 'lannister.png'),
('House Targaryen', 'Fire and Blood', 'Dragonstone', 'Blackfyre & Dark Sister', 'House Targaryen adalah dinasti penakluk Westeros, terkenal dengan ikatan darah dengan para naga dan tradisi pernikahan sesama anggota keluarga untuk menjaga kemurnian darah.', 'targaryen.png'),
('House Baratheon', 'Ours is the Fury', 'The Stormlands', 'Orphan-Maker & Widow''s Wail', 'House Baratheon menguasai Stormlands dan pernah menduduki Iron Throne setelah Robert''s Rebellion mengakhiri dinasti Targaryen.', 'baratheon.png'),
('House Greyjoy', 'We Do Not Sow', 'The Iron Islands', 'Nightfall', 'House Greyjoy adalah penguasa Iron Islands, dikenal sebagai pelaut ulung dan perompak yang menyembah Drowned God.', 'greyjoy.png'),
('House Martell', 'Unbowed, Unbent, Unbroken', 'Dorne', 'Lance', 'House Martell menguasai Dorne, wilayah gurun di selatan Westeros yang memiliki budaya dan hukum suksesi yang berbeda dari kerajaan lain.', 'martell.png'),
('House Tully', 'Family, Duty, Honor', 'The Riverlands', 'Brightroar (Replica)', 'House Tully menguasai Riverlands dari Riverrun, dikenal karena prinsip kekeluargaan, kewajiban, dan kehormatan.', 'tully.png'),
('House Tyrell', 'Growing Strong', 'The Reach', 'Various Blades', 'House Tyrell menguasai The Reach dari Highgarden, salah satu wilayah paling subur dan kaya di Westeros, terkenal lewat kelicikan politik.', 'tyrell.png'),
('House Arryn', 'As High as Honor', 'The Vale', 'Various Blades', 'House Arryn menguasai The Vale of Arryn dari benteng tak tertembus Eyrie, salah satu Great House tertua yang masih berdiri sejak Age of Heroes.', 'arryn.png');

-- Film / Season
INSERT INTO film (judul, kategori, durasi, tahun, rating, peringatan, pemeran, genre, tags, sinopsis, poster, banner_hero) VALUES
('Game of Thrones: Season 1', 'TV Series', '10 Episode', 2011, '9.1', '18+ (Kekerasan Intens, Konten Dewasa)', 'Emilia Clarke, Kit Harington, Peter Dinklage, Sean Bean', 'Fantasy, Drama, Action', 'Game of Thrones, Westeros', 'Sembilan keluarga bangsawan berjuang untuk menguasai tanah Westeros yang penuh intrik dan pengkhianatan, sementara ancaman kuno bangkit dari balik The Wall.', 'got.png', 'background-naga.png'),
('House of the Dragon: Season 1', 'TV Series', '10 Episode', 2022, '8.4', '18+ (Kekerasan Intens, Konten Dewasa)', 'Matt Smith, Emma D''Arcy, Paddy Considine, Olivia Cooke', 'Fantasy, Drama, Action', 'House of the Dragon, Targaryen', 'Kisah perpecahan House Targaryen 200 tahun sebelum kelahiran Daenerys, yang memicu perang saudara berdarah dikenal sebagai Dance of the Dragons.', 'hod.png', 'background-naga.png');

-- Episode (Game of Thrones Season 1 - id_film = 1)
INSERT INTO episode (id_film, eps_num, durasi, judul_eps, video_url, thumbnail, deskripsi) VALUES
(1, 1, '1j 2m', 'Winter Is Coming', 'https://www.youtube.com/watch?v=KPLWWIOCOOQ', 'placeholder.jpg', 'Lord Eddard Stark dipanggil ke King''s Landing untuk menjadi Hand of the King, sementara di Utara, sebuah ancaman kuno mulai bangkit dari balik The Wall.'),
(1, 2, '56m', 'The Kingsroad', 'https://www.youtube.com/watch?v=KPLWWIOCOOQ', 'placeholder.jpg', 'Keluarga Stark berpisah menuju tujuan masing-masing, sementara Jon Snow memulai perjalanannya ke Night''s Watch.');

-- Anggota Faksi (contoh karakter)
INSERT INTO anggota_faksi (id_faksi, nama_karakter, gelar, foto_karakter, bio) VALUES
(1, 'Eddard Stark', 'Lord of Winterfell, Warden of the North', 'placeholder.jpg', 'Eddard "Ned" Stark adalah Lord Winterfell yang dikenal akan kejujuran dan kehormatannya yang tak tergoyahkan, bahkan ketika hal itu membahayakan dirinya sendiri.'),
(1, 'Jon Snow', 'Lord Commander of the Night''s Watch', 'placeholder.jpg', 'Putra tidak sah (atau begitulah yang diyakini) dari Eddard Stark, Jon Snow tumbuh di Winterfell sebelum bergabung dengan Night''s Watch untuk menjaga The Wall.'),
(2, 'Tyrion Lannister', 'Hand of the King', 'placeholder.jpg', 'Anggota House Lannister yang paling cerdas, dikenal dengan kecerdikan dan kecintaannya pada anggur, sering dianggap remeh karena perawakannya.'),
(3, 'Daenerys Targaryen', 'Mother of Dragons, Khaleesi', 'placeholder.jpg', 'Anak terakhir dari Raja Aerys II Targaryen, Daenerys bersumpah untuk merebut kembali Iron Throne dengan bantuan tiga ekor naga miliknya.');
