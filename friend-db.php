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

function followRestaurant($restaurant_to_follow, $computing_ID)
{
    global $db;
    $query = "insert into Follows value(:Rname, :computing_ID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $restaurant_to_follow);
    $statement->bindValue(':computing_ID', $computing_ID);
    $statement->execute();
    $statement->closeCursor();
}
function selectFriends($id)
{
    global $db;
    $query = "select * from Friends_to where computing_ID=:id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

}
function checkFriends($id1,$id2)
{
    global $db;
    $query = "select * from Friends_to where computing_ID=:id1 AND Friends_computing_ID=:id2";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id1', $id1);
    $statement->bindValue(':id2', $id2);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;

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

function selectUser($id)
{
    global $db;
    $query = "select * from user where computing_id=:id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function searchUser($id)
{
    global $db;
    $query = "select * from user where computing_id=:id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getPW($id)
{
    global $db;
    $query = "select password from user where computing_id=:id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result= $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
function addUser($id, $email, $fn,$ln,$pw,$sy,$age) {
    global $db;
    $query = "insert into user value(:id, :email, :fn, :ln, :pw, :sy, :age)";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':fn', $fn);
    $statement->bindValue(':ln', $ln);
    $statement->bindValue(':pw', $pw);
    $statement->bindValue(':sy', $sy);
    $statement->bindValue(':age', $age);
    $statement->execute();
    $statement->closeCursor();

}

function addFriends($id1, $id2) {
    global $db;
    $query = "insert into Friends_to value(:id1, :id2)";
    $statement = $db->prepare($query);
    $statement->bindValue(':id1', $id1);
    $statement->bindValue(':id2', $id2);
    $statement->execute();
    $statement->closeCursor();
}
function deleteFriends($id1,$id2)
{
    global $db;
    $query = "delete from Friends_to where computing_ID=:id1 AND Friends_computing_ID=:id2";
    $statement = $db ->prepare($query);
    $statement->bindValue(':id1', $id1);
    $statement->bindValue(':id2', $id2);
    $statement->execute();
    $statement->closeCursor();
}

function selectFollows($computing_ID){
    global $db;
    $query = "select Rname, address, type from Restaurant natural join Follows where computing_ID=:computing_ID";
    $statement = $db ->prepare($query);
    $statement->bindValue(":computing_ID", $computing_ID);
    $statement->execute();
    $result= $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function checkIfUserFollows($computing_ID, $Rname){
    global $db;
    $query = "select * from Follows where computing_ID=:computing_ID and Rname=:Rname";
    $statement = $db ->prepare($query);
    $statement->bindValue(":computing_ID", $computing_ID);
    $statement->bindValue(":Rname", $Rname);
    $statement->execute();
    $exists = 0;
    if($Rname = $statement->fetch(PDO::FETCH_ASSOC)){
        $exists = 1;
    }else{
        $exists = 0;
    }
    $statement->closeCursor();
    return $exists;
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

function unfollowRestaurant($restaurant_to_unfollow, $computing_ID)
{
    global $db;
    $query = "delete from Follows where Rname=:Rname and computing_ID=:computingID";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Rname', $restaurant_to_unfollow);
    $statement->bindValue(':computingID', $computing_ID);
    $statement->execute();
    $statement->closeCursor();
}

function updateRestaurant($Rname, $address, $type) {
    global $db;
    $query = "update Restaurant set address=:address, type=:type where Rname=:Rname";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':type', $type);
    $statement->execute();
    $statement->closeCursor();

}

function updateFood($Rname, $name, $price) {
    global $db;
    $query = "update Food_price set price=:price where Rname=:Rname and name=:name";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();

}

function getRestaurantByName($Rname)
{
    global $db;
    $query = "select * from Restaurant where Rname=:Rname";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    return $results;
}

function getFoodByName($Rname, $name)
{
    global $db;
    $query = "select * from Food_price where Rname=:Rname and name=:name";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    return $results;
}

function selectAllReview($Rname)
{
    global $db;
    $query = "select * from Review where Rname=:Rname";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function addReview($Rname, $Text, $Rating, $Date, $ReviewID, $ReviewType) {
    global $db;
    $query = "insert into Review value(:Rname, :ReviewID, :Rating, :Text, :Date, :ReviewType)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':Text', $Text);
    $statement->bindValue(':Rating', $Rating);
    $statement->bindValue(':Date', $Date);
    $statement->bindValue(':ReviewID', $ReviewID);
    $statement->bindValue(':ReviewType', $ReviewType);
    $statement->execute();
    $statement->closeCursor();

}

function deleteReview($ReviewID)
{
    global $db;
    $query = "delete from Review where ReviewID=:ReviewID";
    $statement = $db ->prepare($query);
    $statement->bindValue(':ReviewID', $ReviewID);
    $statement->execute();
    $statement->closeCursor();
}

function updateReview($Rname, $Text, $Rating, $Date, $ReviewID, $ReviewType) {
    global $db;
    $query = "update Review set Rname=:Rname, ReviewID=:ReviewID, Ratings=:Rating, Text=:Text, Date=:Date, ReviewType=:ReviewType where ReviewID=:ReviewID";
    $statement = $db->prepare($query);
    $statement->bindValue(':Text', $Text);
    $statement->bindValue(':Rating', $Rating);
    $statement->bindValue(':Rname', $Rname);
    $statement->bindValue(':Date', $Date);
    $statement->bindValue(':ReviewID', $ReviewID);
    $statement->bindValue(':ReviewType', $ReviewType);
    $statement->execute();
    $statement->closeCursor();

}

function getReviewByName($ReviewID)
{
    global $db;
    $query = "select * from Review where ReviewID=:ReviewID";
    $statement = $db ->prepare($query);
    $statement->bindValue(':ReviewID', $ReviewID);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    return $results;
}



function selectAllFoodReview($Name)
{
    global $db;
    $query = "select * from food_review where Name=:Name";
    $statement = $db ->prepare($query);
    $statement->bindValue(':Name', $Name);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function addFoodReview($Name, $review_id, $taste_score) {
    global $db;
    $query = "insert into food_review value(:review_id, :Name, :taste_score)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Name', $Name);
    $statement->bindValue(':review_id', $review_id);
    $statement->bindValue(':taste_score', $taste_score);
    $statement->execute();
    $statement->closeCursor();

}

function deleteFoodReview($review_id)
{
    global $db;
    $query = "delete from food_review where review_id=:review_id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':review_id', $review_id);
    $statement->execute();
    $statement->closeCursor();
}

function updateFoodReview($Name, $review_id, $taste_score) {
    global $db;
    $query = "update food_review set review_id=:review_id, Name=:Name, taste_score=:taste_score where review_id=:review_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':Name', $Name);
    $statement->bindValue(':review_id', $review_id);
    $statement->bindValue(':taste_score', $taste_score);
    $statement->execute();
    $statement->closeCursor();

}

function getFoodReviewByName($review_id)
{
    global $db;
    $query = "select * from food_review where review_id=:review_id";
    $statement = $db ->prepare($query);
    $statement->bindValue(':review_id', $review_id);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    return $results;
}
?>