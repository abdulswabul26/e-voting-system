CREATE DATABASE IF NOT EXISTS my_database;
USE my_database;

-- Table to store user information (voters and admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    reg_no VARCHAR(50) NOT NULL UNIQUE,          -- Registration number, must be unique
    full_name VARCHAR(100) NOT NULL,             -- Full name of the user
    email VARCHAR(100) NOT NULL UNIQUE,          -- Email address, must be unique
    role ENUM('voter', 'admin') DEFAULT 'voter', -- User role: voter or admin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of account creation
);

-- Table to store candidate information
CREATE TABLE IF NOT EXISTS candidates (
    candidate_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,             -- Candidate's full name
    reg_no VARCHAR(50) NOT NULL UNIQUE,          -- Candidate's registration number, unique
    photo_url VARCHAR(255),                      -- Candidate photo path
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of candidate registration
);

-- Table to store votes
CREATE TABLE votes (
    vote_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,         -- The voter (references users table)
    candidate_id INT NOT NULL,    -- The candidate (references users table)
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of voting
    UNIQUE (user_id),             -- Prevents double-voting by the same user
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (candidate_id) REFERENCES users(user_id)
);

-- Table to store OTPs for user verification
CREATE TABLE user_otps (
    otp_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,                         -- References users table
    otp_code VARCHAR(10) NOT NULL,                -- The generated OTP code
    expires_at DATETIME NOT NULL,                 -- Expiration time for OTP
    is_used BOOLEAN DEFAULT FALSE,                -- Marks OTP as used once verified
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of OTP creation
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Sample insertions for users
INSERT INTO users (reg_no, full_name, email, role) VALUES
('2024-04-26244', 'Alice Namatovu', 'alice.namatovu@example.com', 'voter'),
('2024-04-26245', 'Brian Mugisha', 'brian.mugisha@example.com', 'voter'),
('2024-04-26246', 'Catherine Kintu', 'catherine.kintu@example.com', 'admin');

-- Sample insertions for candidates
INSERT INTO candidates (full_name, reg_no) VALUES
('David Ssemanda', '2024-04-26247'),
('Esther Nakato', '2024-04-26248');
