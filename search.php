<?php
// Database configuration constants
define('DB_SERVER', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'tourism_search_db');

// Start output buffering to control HTML output
ob_start();

// Function to establish database connection
function getDatabaseConnection() {
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
    
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    
    return $connection;
}

// Function to sanitize and validate input
function sanitizeInput($input) {
    return trim(htmlspecialchars(strip_tags($input)));
}

// Function to display results in HTML format
function displayResults($results, $searchCity) {
    $homestays = [];
    $locations = [];
    
    // Separate results by type
    foreach ($results as $result) {
        if ($result['type'] === 'Homestay') {
            $homestays[] = $result;
        } else {
            $locations[] = $result;
        }
    }
    
    $output = '';
    
    // Display Homestays first
    if (!empty($homestays)) {
        $output .= '<div class="result-section">';
        $output .= '<h2>🏠 Homestays in ' . htmlspecialchars($searchCity) . '</h2>';
        
        foreach ($homestays as $homestay) {
            $output .= '<div class="result-item">';
            $output .= '<h3>' . htmlspecialchars($homestay['name']) . '</h3>';
            $output .= '<span class="type">Homestay</span>';
            $output .= '<p class="description">' . htmlspecialchars($homestay['description']) . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
    }
    
    // Display Near Locations second
    if (!empty($locations)) {
        $output .= '<div class="result-section">';
        $output .= '<h2>📍 Near Locations in ' . htmlspecialchars($searchCity) . '</h2>';
        
        foreach ($locations as $location) {
            $output .= '<div class="result-item">';
            $output .= '<h3>' . htmlspecialchars($location['name']) . '</h3>';
            $output .= '<span class="type">Location</span>';
            $output .= '<p class="description">' . htmlspecialchars($location['description']) . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
    }
    
    return $output;
}

// Main search logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_city']) && !empty($_POST['search_city'])) {
    
    // Sanitize the search input
    $searchCity = sanitizeInput($_POST['search_city']);
    
    // Establish database connection
    $connection = getDatabaseConnection();
    
    // Prepare the SQL query with LIKE operator for flexible matching
    $sql = "SELECT id, name, type, city, description FROM places WHERE city LIKE ? ORDER BY type DESC, name ASC";
    
    if ($stmt = $connection->prepare($sql)) {
        // Bind the search parameter with wildcards for partial matching
        $searchParam = '%' . $searchCity . '%';
        $stmt->bind_param("s", $searchParam);
        
        // Execute the query
        $stmt->execute();
        
        // Get the results
        $result = $stmt->get_result();
        $results = [];
        
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        
        // Close statement
        $stmt->close();
        
        // Display results or no results message
        if (!empty($results)) {
            echo displayResults($results, $searchCity);
        } else {
            echo '<div class="no-results">';
            echo '<p>Sorry, nothing found in that city. 😞</p>';
            echo '<p>Try searching for "Goa" or "Delhi" to see sample results.</p>';
            echo '</div>';
        }
        
    } else {
        echo '<div class="no-results">';
        echo '<p>Error preparing search query. Please try again.</p>';
        echo '</div>';
    }
    
    // Close database connection
    $connection->close();
    
} else {
    // If no POST data or empty search city
    echo '<div class="no-results">';
    echo '<p>Please enter a city name to search for homestays and locations.</p>';
    echo '</div>';
}

// End output buffering and send output
ob_end_flush();
?>