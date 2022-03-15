<?php

function insertToDB(PDO $db, csvComparer $csvComparer, $entity_type)
{
    foreach ($csvComparer->getArrayForDB() as $result) {
        $sql = "INSERT INTO 
        status_history 
        (registry_no, name, entity_type, old_status, new_status) 
        VALUES 
        (
            '" . $result[0] . "',
            '" . str_replace("'", "\"", $result[1]) . "', 
            '" . $entity_type . "',
            '" . $result[2] . "',
            '" . $result[3] . "'
        )";  
        $statement = $db->query($sql);
    }
}