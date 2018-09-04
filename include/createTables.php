<?php

    public function createInterestTable() {

        $query = "CREATE TABLE diu_interest (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        event_id INT( 10 ) NOT NULL ,
                        user_id INT( 10 ) NOT NULL ,
                        PRIMARY KEY ( id ) ,
                        UNIQUE (
                         id 
                        )
                    )";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

    public function createEventTable() {

        $query = "CREATE TABLE diu_event (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        name VARCHAR( 300 ) NOT NULL ,
                        place VARCHAR( 200 ) NOT NULL ,
                        start_date DATE NOT NULL ,
                        end_date DATE NOT NULL ,
                        capacity INT( 10 ) NOT NULL ,
                        budget INT( 10 ) NOT NULL ,
                        moderator VARCHAR( 200 ) NOT NULL ,
                        contact VARCHAR( 100 ) NOT NULL ,
                        details VARCHAR( 300 ) NOT NULL ,
                        PRIMARY KEY ( id ) ,
                        UNIQUE (
                         id 
                        )
                    ) 
                    ";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

    public function createImgTable() {

        $query = "CREATE TABLE Image (
                id INT( 10 ) NOT NULL AUTO_INCREMENT,
                event_id INT( 10 ) NOT NULL,
                img_path VARCHAR( 200 ) NOT NULL,
                PRIMARY KEY (id),
                UNIQUE (id)
                )";

        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

        public function createUserTable() {

        $query = "create table diu_users(
                       id int(11) primary key auto_increment,
                       unique_id varchar(23) not null unique,
                       name varchar(100) not null,
                       email varchar(100) not null unique,
                       is_admin int(5) not null,
                       encrypted_password varchar(80) not null,
                       salt varchar(10) not null,
                       created_at datetime,
                       updated_at datetime null,
                       gender varchar(20) not null,
                       age int(10),
                       profession varchar(50)
                    )
                    ";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

    public function createPlaceTable(){
        $query = "create table diu_place(
                       id int(11) primary key auto_increment,
                       name varchar(200) not null,
                       details TEXT,
                       link varchar(300),
                       UNIQUE(id)
                    )
                    ";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }   
    }

    public function createAdTable(){
        $query = "CREATE TABLE diu_ad(
                       id int(11) primary key auto_increment,
                       title varchar(200) not null,
                       price int(10) not null,
                       link varchar(300),
                       details TEXT,
                       UNIQUE(id)
                    )
                    ";

        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }   
    }

    public function createClickTable() {

        $query = "CREATE TABLE diu_click (
                        id INT( 10 ) NOT NULL AUTO_INCREMENT ,
                        ad_id INT( 10 ) NOT NULL ,
                        user_id INT( 10 ) NOT NULL ,
                        PRIMARY KEY ( id ) ,
                        UNIQUE (
                         id 
                        )
                    )";


        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }
    }

?>