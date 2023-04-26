<?php
function addRestaurant($Rname, $address, $type) {
    global $db;
    $query = "insert into Restaurant value(:Rname, :address, :type)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':type', $type);
    $statement->execute();
    $statement->closeCursor();

}
function addFood($Rname, $name, $price) {
    global $db;
    $query = "insert into Food_price value(:Rname, :name, :price)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();

}

function selectAllRestaurant()
{
    global $db;
    $query = "select * from Restaurant";
    $statement = $db ->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function selectFood($food_to)
{
    global $db;
    $query = "select * from Food_price where Rname=:food_to";
    $statement = $db ->prepare($query);
    $statement->bindValue(':food_to', $food_to);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function deleteRestaurant($Restaurant_to_delete)
{
    global $db;
    $query = "delete from Restaurant where Rname=:Restaurant_to_delete";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Restaurant_to_delete', $Restaurant_to_delete);
    $statement->execute();
    $statement->closeCursor();
}

function deleteFood($Food_to_delete, $name)
{
    global $db;
    $query = "delete from Food_price where Rname=:Food_to_delete and name=:name";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Food_to_delete', $Food_to_delete);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();
}


?>