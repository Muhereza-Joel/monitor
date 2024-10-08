DELIMITER $$
CREATE  PROCEDURE `GetResponses`()
BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @indicator_id := NULL;

    -- Query to join tables and calculate row numbers
    SELECT 
        response_number.*,
        indicators.indicator_title,
        indicators.baseline,
        indicators.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses.*,
                -- Calculate row number for each indicator_id partition
                @row_number := IF(@indicator_id = responses.indicator_id, @row_number + 1, 1) AS response_tag,
                @indicator_id := responses.indicator_id
            FROM 
                responses
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @indicator_id := NULL) AS vars
            ORDER BY 
                responses.indicator_id, responses.created_at
        ) AS response_number
    JOIN 
        indicators ON indicators.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.indicator_id, response_number.user_id, response_number.created_at;
END$$
DELIMITER ;