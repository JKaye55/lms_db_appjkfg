<?php
class database{
 
    function opencon():PDO{
        return new PDO(
            dsn: 'mysql:host=localhost;
            dbname=lms_appjkfg05',
            username: 'root',
            password: '');
    }
 
    function signupUser($firstname, $lastname, $birthday, $email, $sex, $phone, $username, $password, $profile_picture_path) {
 
        $con = $this->opencon();
       
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO users (user_FN, user_LN, user_birthday, user_sex, user_email, user_phone, user_username, user_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $birthday, $sex, $email, $phone, $username, $password]);
           
            $userID = $con->lastInsertId();
           
 
            $stmt = $con->prepare("INSERT INTO users_pictures (user_id, user_pic_url) VALUES (?, ?)");
            $stmt->execute([$userID, $profile_picture_path]);
 
            $con->commit();
 
            return $userID;
 
        } catch (PDOException $e) {
 
            $con->rollback();
            return false;
 
        }
 
    }
 
    function insertAddress($userID, $street, $barangay, $city, $province) {
 
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO Address (ba_street, ba_barangay, ba_city, ba_province) VALUES (?, ?, ?, ?)");
            $stmt->execute([$street, $barangay, $city, $province]);
 
            $addressID = $con->lastInsertId();
 
            $stmt = $con->prepare("INSERT INTO users_address (user_id, address_id) VALUES (?, ?)");
            $stmt->execute([$userID, $addressID]);
 
            $con->commit();
 
            return true;
 
        } catch (PDOException $e) {
 
            $con->rollback();
            return false;
 
        }
 
    }

 function loginUser($email, $password) {

        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM Users WHERE user_email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['user_password'])){

            return $user;
            

        } else {

            return false;
        }
        


    }
 

    function addAuthor($authorfirst, $authorlast, $authorbday, $authornat) {
        $con = $this->opencon();


           try {

        $con->beginTransaction();

        $stmt = $con->prepare("INSERT INTO authors (author_FN, author_LN, author_birthday, author_nat) VALUES (?, ?, ?, ?)");
        $stmt->execute([$authorfirst, $authorlast, $authorbday, $authornat]);
        $auhtorID = $con->lastInsertId();

        $con->commit();
 
            return $auhtorID;

           } catch (PDOException $e) {
 
            $con->rollback();
            return false;
 
        }


    }   


    function addGenre($genreName) {
 $con = $this->opencon();


           try {

        $con->beginTransaction();

        $stmt = $con->prepare("INSERT INTO genres (genre_name) VALUES (?)");
        $stmt->execute([$genreName]);
        $genreID = $con->lastInsertId();

        $con->commit();
 
            return $genreID;

           } catch (PDOException $e) {
 
            $con->rollback();
            return false;
 
        }



    }

    function viewAuthors(): array{
        $con=$this->opencon();
        return $con->query("SELECT * FROM Authors")->fetchAll();
    }

    function viewAuthorsID($id) {
        $con = $this->opencon();
        $stmt= $con->prepare("SELECT * FROM Authors Where author_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function updateAuthors( $authorfirst, $authorlast, $authorbday, $authornat, $authorId) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE authors SET author_FN=?, author_LN=?, author_birthday=?, author_nat=?  WHERE author_id=?");
        $query->execute([$authorfirst, $authorlast, $authorbday, $authornat, $authorId]);
        // Update successful
        $con->commit();
        return true;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
         $con->rollBack();
        return false; // Update failed
    }
}

    function viewGenres(): array{
        $con=$this->opencon();
        return $con->query("SELECT * FROM genres")->fetchAll();
    }

    function viewGenreID($id) {
        $con = $this->opencon();
        $stmt= $con->prepare("SELECT * FROM genres Where genre_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
  function updateGenres($genreName, $id) {
    try {
        $con = $this->opencon();
        $con->beginTransaction();
        $query = $con->prepare("UPDATE genres SET genre_name=? WHERE genre_id=?");
        $query->execute([$genreName, $id]);
        // Update successful
        $con->commit();
        return true;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log error, return false, etc.)
         $con->rollBack();
        return false; // Update failed
    }
}

}
?>