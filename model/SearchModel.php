<?php

namespace model;

use TeamTNT\TNTSearch\TNTSearch;

class SearchModel
{
    private $database;
    private $tnt;

    public function __construct($database)
    {
        $this->database = $database; // MySQLi connection
        $this->init();
    }

    private function init()
    {
        $this->tnt = new TNTSearch();

        $this->tnt->loadConfig([
            'driver'   => 'mysql', // Ensure the driver is set to mysql
            'host'     => getenv('DB_HOST'), // Make sure your .env file has these values set correctly
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'storage'  => './storage', // Ensure this directory exists and is writable
        ]);
    }

    // Create search index for the specified category/table
    public function createSearchIndex($category)
    {
        // Create a new index for the table/category
        $indexer = $this->tnt->createIndex("{$category}.index");

        // Retrieve the columns from the specified category/table
        $columnsResult = $this->database->query("DESCRIBE $category");

        if ($columnsResult) {
            $columns = [];

            // Fetch the columns and build the SELECT statement
            while ($row = $columnsResult->fetch_assoc()) {
                $columns[] = $row['Field']; // 'Field' contains the column names
            }

            $columnsList = implode(',', $columns); // Convert array to a comma-separated string
            $indexer->query("SELECT $columnsList FROM $category"); // Adjust as necessary
            $indexer->run();
        } else {
            error_log("Error retrieving columns: " . $this->database->error . "\n");
        }
    }


    // Search function for the specified category/table
    public function search($category = '', $query = '')
    {
        // Default to the 'responses' table if category is empty and no query is provided
        if (empty($category) && empty($query)) {
            $category = 'responses'; // Set the default category
        }

        // Set the index for the category/table
        $this->tnt->selectIndex("{$category}.index");

        // Perform the search
        $results = $this->tnt->search($query);

        // Initialize an array to hold the records
        $recordsArray = [];

        // Fetch the records based on the result IDs
        if (isset($results['ids']) && is_array($results['ids']) && count($results['ids']) > 0) {
            $ids = array_map('intval', $results['ids']); // Convert IDs to integers
            $idsList = implode(',', $ids);

            // Prepare the SQL query to fetch the records
            $sql = "SELECT * FROM $category WHERE id IN ($idsList)";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            
            if ($stmt) {
                $result = $stmt->get_result();
                // Fetch all records and store them in the array
                while ($record = $result->fetch_assoc()) {
                    // Optionally highlight query terms in each record
                    if (!empty($query)) {
                        foreach ($record as $column => $value) {
                            $record[$column] = $this->highlightQuery($value, $query);
                        }
                    }
                    $recordsArray[] = $record; // Append each record to the array
                }
                return $recordsArray; // Return the array of records
                $stmt->fetch();

                $stmt->close();
            } else {
                error_log("Error executing query: " . $this->database->error . "\n");
            }
        } else {
            error_log("No valid IDs found for the search.\n"); // Debug message if no IDs are found
        }

        return []; // Return an empty array if no results
    }

    // Helper method to highlight query terms
    private function highlightQuery($text, $query)
    {
        // Escape query for safety
        $escapedQuery = preg_quote($query, '/'); // Escape special characters in the query
        // Use preg_replace to wrap query matches in a span
        return preg_replace("/($escapedQuery)/i", '<span class="highlight">$1</span>', $text);
    }
}
