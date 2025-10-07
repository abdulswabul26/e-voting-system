<?php
function getAllVotes($conn) {
    // Prepare SQL query
    $sql = "SELECT v.vote_id, v.voter_id, v.candidate_id, v.position, v.timestamp, 
                   c.name AS candidate_name, u.fullname AS voter_name
            FROM votes v
            LEFT JOIN candidates c ON v.candidate_id = c.candidate_id
            LEFT JOIN users u ON v.voter_id = u.user_id
            ORDER BY v.timestamp DESC";

    // Execute query
    $result = $conn->query($sql);

    // Check if records exist
    if ($result->num_rows > 0) {
        echo "<table border='1' cellspacing='0' cellpadding='6'>
                <tr>
                    <th>Vote ID</th>
                    <th>Voter Name</th>
                    <th>Candidate</th>
                    <th>Position</th>
                    <th>Date/Time</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['vote_id']}</td>
                    <td>{$row['voter_name']}</td>
                    <td>{$row['candidate_name']}</td>
                    <td>{$row['position']}</td>
                    <td>{$row['timestamp']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No votes have been recorded yet.</p>";
    }
}
?>
