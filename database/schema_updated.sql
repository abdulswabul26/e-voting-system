CREATE DATABASE IF NOT EXISTS evotingdb;
USE evotingdb;

-- Table to store user information (voters and admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    reg_no VARCHAR(50) NOT NULL UNIQUE,          -- Registration number, must be unique
    full_name VARCHAR(100) NOT NULL,             -- Full name of the user
    email VARCHAR(100) NOT NULL UNIQUE,          -- Email address, must be unique
    department VARCHAR(100),                     -- Department (added for dashboard compatibility)
    role ENUM('voter', 'admin') DEFAULT 'voter', -- User role: voter or admin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of account creation
);

-- Table to store election information
CREATE TABLE IF NOT EXISTS elections (
    election_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,                 -- Election title
    election_date DATE NOT NULL,                 -- Election date
    status ENUM('upcoming', 'open', 'closed') DEFAULT 'upcoming', -- Election status
    description TEXT,                            -- Election description
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table to store candidate information
CREATE TABLE IF NOT EXISTS candidates (
    candidate_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,             -- Candidate's full name
    reg_no VARCHAR(50) NOT NULL UNIQUE,          -- Candidate's registration number, unique
    party VARCHAR(100),                          -- Political party (added for dashboard)
    bio TEXT,                                    -- Candidate biography (added for dashboard)
    photo_url VARCHAR(255),                      -- Candidate photo path
    election_id INT,                             -- Election this candidate is running in
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (election_id) REFERENCES elections(election_id) ON DELETE SET NULL
);

-- Table to store votes
CREATE TABLE votes (
    vote_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,         -- The voter (references users table)
    candidate_id INT NOT NULL,    -- The candidate (references candidates table)
    election_id INT NOT NULL,     -- The election (references elections table)
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of voting
    UNIQUE (user_id, election_id), -- Prevents double-voting in the same election
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (candidate_id) REFERENCES candidates(candidate_id) ON DELETE CASCADE,
    FOREIGN KEY (election_id) REFERENCES elections(election_id) ON DELETE CASCADE
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

CREATE TABLE IF NOT EXISTS elections (
    election_id INT AUTO_INCREMENT PRIMARY KEY,   -- Unique ID for each election
    title VARCHAR(150) NOT NULL,                  -- Election title (e.g., "Student Guild Elections 2025")
    description TEXT,                             -- Optional description
    election_date DATE NOT NULL,                  -- The election date
    status ENUM('upcoming', 'open', 'closed') NOT NULL DEFAULT 'upcoming', -- Election state
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- When the record was created
);

-- Sample insertions for users
INSERT INTO users (reg_no, full_name, email, department, role) VALUES
('2024-04-26244', 'Alice Namatovu', 'alice.namatovu@example.com', 'Computer Science', 'voter'),
('2024-04-26245', 'Brian Mugisha', 'brian.mugisha@example.com', 'Engineering', 'voter'),
('2024-04-26246', 'Catherine Kintu', 'catherine.kintu@example.com', 'Administration', 'admin');

-- Sample insertions for elections
INSERT INTO elections (title, election_date, status, description) VALUES
('2025 National Elections', '2025-10-05', 'open', 'National presidential and parliamentary elections');

-- Sample insertions for candidates
INSERT INTO candidates (full_name, reg_no, party, bio, election_id) VALUES
('Jane Kato', '2024-04-26247', 'Unity Party', 'Focus: education & health', 1),
('John Okello', '2024-04-26248', 'Progressive Movement', 'Focus: jobs & infrastructure', 1),
('Sara Namutebi', '2024-04-26249', 'Green Future', 'Focus: environment & youth', 1);


