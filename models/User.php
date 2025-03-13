<?php

require_once("../config/dbconfig.php");

class User extends Dbconfig{

    protected function authenticated($username, $password){
        try {
            $query = "SELECT password FROM users WHERE username = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    return ["status" => 200, "message" => "Login successful!"];
                } else {
                    return ["status" => 401, "message" => "Invalid password!"];
                }
            } 
            
            return ["status" => 404, "message" => "Unauthenticated"];
    
        } catch (mysqli_sql_exception $e) {
            return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
        }
    }
    

    protected function registered($username, $password){
        try {
            $query = "INSERT INTO users (username, password) VALUES (?, ?)";
           
            $stmt = $this->connect()->prepare($query);
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
           
            $stmt->bind_param("ss", $username, $hashed_password);
           
            $stmt->execute();
            
            if ($stmt->execute()) {
                
                return ["status" => 200, "message" => "Registration successful!"];
            } else {
                return ["status" => 500, "message" => "Registration failed!"];
            }

        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ["status" => 409, "message" => "Username already exists!"];
            }
            return ["status" => 500, "message" => $e->getMessage()];
        }
    }
}