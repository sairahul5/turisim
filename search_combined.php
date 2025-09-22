<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Search - Find Homestays & Locations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Find Your Next Homestay or Adventure 🌍</h1>
            <p>Discover amazing homestays and explore nearby attractions</p>
        </header>

        <div class="search-section">
            <form method="POST" action="" class="search-form">
                <div class="input-group">
                    <input type="text" name="search_city" placeholder="Enter city name (e.g., Goa, Delhi)" required>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>

        <div id="results_container" class="results-container">
            <?php
            // Database configuration constants
            define('DB_SERVER', 'localhost');
            define('DB_USER', 'your_username');
            define('DB_PASSWORD', 'your_password');
            define('DB_NAME', 'tourism_search_db');

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
                
                try {
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
                            echo '<h2>� No Results Found</h2>';
                            echo '<p><strong>Sorry, we could not find any homestays or locations in "' . htmlspecialchars($searchCity) . '"</strong></p>';
                            echo '<p>We currently have data for the following locations:</p>';
                            echo '<ul style="text-align: left; display: inline-block;">';
                            echo '<li>🏖️ <strong>Goa</strong> - Beach homestays and coastal attractions</li>';
                            echo '<li>🏛️ <strong>Delhi</strong> - Heritage homestays and historical sites</li>';
                            echo '<li>🌴 <strong>Panaji</strong> - Backwater experiences</li>';
                            echo '<li>🏙️ <strong>NCR</strong> - Urban heritage locations</li>';
                            echo '</ul>';
                            echo '<p><em>Please try searching for one of the above locations!</em></p>';
                            echo '</div>';
                        }
                        
                    } else {
                        echo '<div class="no-results">';
                        echo '<p>Error preparing search query. Please try again.</p>';
                        echo '</div>';
                    }
                    
                    // Close database connection
                    $connection->close();
                    
                } catch (Exception $e) {
                    echo '<div class="no-results">';
                    echo '<h2>⚠️ Connection Error</h2>';
                    echo '<p>Unable to connect to database. Please check your configuration.</p>';
                    echo '<p><em>Error: ' . htmlspecialchars($e->getMessage()) . '</em></p>';
                    echo '</div>';
                }
                
            } else {
                // Default message when page loads
                echo '<div class="no-results">';
                echo '<h2>🔍 Welcome to Tourism Search</h2>';
                echo '<p>Enter a city name above to search for homestays and tourist locations.</p>';
                echo '<p><strong>Available locations:</strong> Goa, Delhi, Panaji, NCR</p>';
                echo '<p><em>Try searching "Tamil Nadu" or "Kerala" to see the no results message!</em></p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Tourism Search Platform - Discover Local Experiences</p>
    </footer>
</body>
</html>