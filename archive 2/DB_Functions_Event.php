<?php

class DB_Functions_Event {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /*****************************************************************************
                                    AUXILIARY
    *****************************************************************************/

    public function formatDate($date){
        list($day, $month, $year) = split('[/.-]', $date);
        
        if($day < 10){
            $day = '0'.$day;
        }
        if($month < 10){
            $month = '0'.$month;
        }
        
        $dateFormat = $year . '-' . $month . '-' . $day;

        return $dateFormat;
    }

    public function reFormatDate($date){
        list($year, $month, $day) = split('[/.-]', $date);
        
        if($year > 31){
            $dateFormat = $day . '-' . $month . '-' . $year;
            return $dateFormat;
        }

        else{
            return $date;
        }
    }

    /*****************************************************************************
                                    EVENT
    *****************************************************************************/
    /**
     * Storing new event
     * returns event details
     */
    public function storeEvent($name, $place, $start_date, $end_date, $capacity, $budget, $moderator, $contact, $details) {

        //$ueid = uniqid('', true);
        //$dateFormat = $this->formatDate($start_date);

        //$start_date = $this->formatDate($start_date);
        //$end_date = $this->formatDate($end_date);

        $stmt = $this->conn->prepare("INSERT INTO 
                                        diu_event(name, place, start_date, end_date, capacity, budget, moderator, contact, details) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiisss", $name, $place, $start_date, $end_date, $capacity, $budget, $moderator, $contact, $details);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;*/
            return true;
        } else {
            return false;
        }
    }

    public function updateEvent($id, $name, $place, $start_date, $end_date, $capacity, $budget, $moderator, $contact, $details) {

        $stmt = $this->conn->prepare("UPDATE diu_event
                                        SET name = ?, place = ?, start_date = ?, end_date = ?, capacity = ?,
                                        budget = ?, moderator = ?, contact = ?, details = ?
                                        WHERE id = ?");
        $stmt->bind_param("ssssiisssi", $name, $place, $start_date, $end_date, $capacity, $budget, $moderator, $contact, $details, $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;*/
            return true;
        } else {
            return false;
        }
    }

    public function storeTestEvent() {

        $a = 'a';
        $b = 'b';
        $c = '01-01-3000';
        $d = '01-02-3000';
        $e = '5';
        $f = '6';
        $g = 'g';
        $h = 'h';
        $i = 'i';
        
        $query = 'INSERT INTO `diu_event` (`id`, `name`, `place`, `start_date`, `end_date`, `capacity`, `budget`, `moderator`, `contact`, `details`) 
                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiisss", $a, $b, $c, $d, $e, $f, $g, $h, $i);
        $result = $stmt->execute();
        $stmt->close();

        if($result){
            echo "SUCCESS!";
        }
        else{
            echo "failed";
        }
    }

    /**
     * Getting All Events
     * returns event details
     */
    public function getUpcomingEvents() {

        $query = "SELECT * from diu_event WHERE start_date >= CURDATE() ORDER BY start_date ASC";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $sd = $row['start_date'];
            $ed = $row['end_date'];
            $nsd = $this->reFormatDate($sd);
            $ned = $this->reFormatDate($ed);

            $row_array['id'] = $row['id'];
            $row_array['name'] = $row['name'];
            $row_array['place'] = $row['place'];
            $row_array['start_date'] = $nsd;
            $row_array['end_date'] = $ned;

            $row_array['budget'] = $row['budget'];
            $row_array['moderator'] = $row['moderator'];
            $row_array['contact'] = $row['contact'];
            $row_array['details'] = $row['details'];

            if($row['capacity']){
                $row_array['capacity'] = $row['capacity'];            
            }
            else{
                $row_array['capacity'] = 10;               
            }

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function getPastEvents() {

        $query = "SELECT * from diu_event where start_date < CURDATE() ORDER BY start_date DESC";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();
 
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $sd = $row['start_date'];
            $ed = $row['end_date'];
            $nsd = $this->reFormatDate($sd);
            $ned = $this->reFormatDate($ed);

            $row_array['id'] = $row['id'];
            $row_array['name'] = $row['name'];
            $row_array['place'] = $row['place'];
            $row_array['start_date'] = $nsd;
            $row_array['end_date'] = $ned;

            $row_array['budget'] = $row['budget'];
            $row_array['moderator'] = $row['moderator'];
            $row_array['contact'] = $row['contact'];
            $row_array['details'] = $row['details'];

            if($row['capacity']){
                $row_array['capacity'] = $row['capacity'];            
            }
            else{
                $row_array['capacity'] = 10;               
            }

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function deleteEvent($id) {

        $stmt = $this->conn->prepare("DELETE from diu_event
                                        WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM event WHERE unique_id = ?");
            $stmt->bind_param("s", $ueid);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;*/
            return true;
        } else {
            return false;
        }
    }

    /*****************************************************************************
                                    INTEREST
    *****************************************************************************/

    /**
     * Storing new interest
     * returns interest details
     */
    public function addInterest($event, $user) {
        
        $stmt1 = $this->conn->prepare("SELECT * FROM diu_interest WHERE event_id = ? AND user_id = ?");
        $stmt1->bind_param("ii", $event, $user);
        $stmt1->execute();
        $stmt1->store_result();

        if ($stmt1->num_rows == 0) {

            $stmt1->close();

            $stmt = $this->conn->prepare("INSERT INTO diu_interest(event_id, user_id) 
                                            VALUES(?, ?)");
            $stmt->bind_param("ii", $event, $user);
            $result = $stmt->execute();
            $stmt->close();

            // check for successful store
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM diu_interest WHERE event_id = ? AND user_id = ?");
                $stmt->bind_param("ii", $event, $user);
                $stmt->execute();
                $interest = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                return $interest;
            } else {
                return false;
            }

        }

    }

    public function getAllInterests() {

        $query = "SELECT * from diu_interest";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['event_id'] = $row['event_id'];
            $row_array['user_id'] = $row['user_id'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
        //echo $return_array;

        //$link->close();

    }

    public function getInterstedUsersInEvent($event_id){
        $stmt1 = $this->conn->prepare("SELECT * FROM diu_interest WHERE event_id = ?");
        $stmt1->bind_param("i", $event_id);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $stmt1->close();

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $user_id = $row['user_id'];

            $stmt2 = $this->conn->prepare("SELECT * FROM diu_users WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt2->close();

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                
                $row_array['id'] = $row2['id'];
                $row_array['name'] = $row2['name'];
                $row_array['email'] = $row2['email'];
                $row_array['contact'] = $row2['contact'];

                $row_array['is_admin'] = $row2['is_admin'];

                array_push($return_array, $row_array);
            }
        }

        echo json_encode($return_array);
    }


    /*****************************************************************************
                                    USER
    *****************************************************************************/

    public function getAllUsers() {

        $query = "SELECT * from diu_users";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['unique_id'] = $row['unique_id'];
            $row_array['name'] = $row['name'];
            $row_array['email'] = $row['email'];

            $row_array['created_at'] = $row['created_at'];
            $row_array['gender'] = $row['gender'];
            $row_array['age'] = $row['age'];
            $row_array['profession'] = $row['profession'];

            $row_array['is_admin'] = $row['is_admin'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function setAdmin($email){
        $query = "UPDATE diu_users SET is_admin = 1 
                                     WHERE email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        $stmt->close();

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }        
    }

    /*****************************************************************************
                                    AD
    *****************************************************************************/
    /**
     * Storing new ad
     * returns ad details
     */
    public function storeAd($title, $price, $details, $link) {

        $stmt = $this->conn->prepare("INSERT INTO 
                                        diu_ad(title, price, details, link) 
                                        VALUES(?, ?, ?, ?)");
        $stmt->bind_param("siss", $title, $price, $details, $link);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Getting All Ads
     * returns ad details
     */
    public function getAds() {

        $query = "SELECT * from diu_ad";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $row_array['id'] = $row['id'];

            $row_array['title'] = $row['title'];
            $row_array['price'] = $row['price'];
            $row_array['details'] = $row['details'];
            $row_array['link'] = $row['link'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
    }

    public function getAdStat($ad_id){

        $stmt1 = $this->conn->prepare("SELECT * FROM diu_click WHERE ad_id = ?");
        $stmt1->bind_param("i", $ad_id);
        $stmt1->execute();

        $result = $stmt1->get_result();
        $clickCount = $stmt1->num_rows;
        
        $stmt1->close();

        $return_array = array();

        $male = "male";
        $female = "female";
        $maleCount = 0;
        $femaleCount = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $user_id = $row['user_id'];

            $stmt2 = $this->conn->prepare("SELECT * FROM diu_users WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt2->close();

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                
                if(strtolower($row2[gender]) == $male){
                    $maleCount++;
                }
                elseif (strtolower($row2[gender]) == $female){
                    $femaleCount++;
                }
            }
        }

        $return_array['click'] = $clickCount;
        $return_array['male'] = $maleCount;
        $return_array['female'] = $femaleCount;

        echo json_encode($return_array);
    }

    public function deleteAd($id) {

        $stmt = $this->conn->prepare("DELETE from diu_ad
                                        WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /*****************************************************************************
                                    CLICK
    *****************************************************************************/

    /**
     * Storing new interest
     * returns interest details
     */
    public function addClick($ad, $user) {
        
        $stmt1 = $this->conn->prepare("SELECT * FROM diu_click WHERE ad_id = ? AND user_id = ?");
        $stmt1->bind_param("ii", $ad, $user);
        $stmt1->execute();
        $stmt1->store_result();

        if ($stmt1->num_rows == 0) {

            $stmt1->close();

            $stmt = $this->conn->prepare("INSERT INTO diu_click(ad_id, user_id) 
                                            VALUES(?, ?)");
            $stmt->bind_param("ii", $ad, $user);
            $result = $stmt->execute();
            $stmt->close();

            // check for successful store
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM diu_click WHERE ad_id = ? AND user_id = ?");
                $stmt->bind_param("ii", $ad, $user);
                $stmt->execute();
                $click = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                return $click;
            } else {
                return false;
            }

        }

    }

    public function getAllClicks() {

        $query = "SELECT * from diu_click";
        $result = mysqli_query($this->conn, $query);

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $row_array['id'] = $row['id'];
            $row_array['ad_id'] = $row['ad_id'];
            $row_array['user_id'] = $row['user_id'];

            array_push($return_array, $row_array);
        }

        echo json_encode($return_array);
        //echo $return_array;

        //$link->close();

    }

    public function getUserFromAdClick($ad_id){
        $stmt1 = $this->conn->prepare("SELECT * FROM diu_click WHERE ad_id = ?");
        $stmt1->bind_param("i", $ad_id);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $stmt1->close();

        $return_array = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))

        {
            $user_id = $row['user_id'];

            $stmt2 = $this->conn->prepare("SELECT * FROM diu_users WHERE id = ?");
            $stmt2->bind_param("i", $user_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt2->close();

            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
                
                $row_array['id'] = $row2['id'];
                $row_array['name'] = $row2['name'];
                $row_array['email'] = $row2['email'];
                $row_array['contact'] = $row2['contact'];

                $row_array['is_admin'] = $row2['is_admin'];
                $row_array['gender'] = $row2['gender'];
                $row_array['age'] = $row2['age'];
                $row_array['profession'] = $row2['profession'];

                array_push($return_array, $row_array);
            }
        }

        echo json_encode($return_array);
    }

    /*****************************************************************************
                                    QUERY
    *****************************************************************************/

    
    public function runQuery() {

        //$this->createClickTable();
        /*$query = "INSERT INTO event(name, place, start_date, end_date, capacity, budget, moderator, contact, details) 
                            VALUES('A', 'B', '01-01-3000', '01-02-3000', 5, 100, 'C', '011', 'D')";*/


        
        //$query  = 'ALTER TABLE `event` CHANGE `moderator` `moderator` VARCHAR(300)';


        /*$query = "DROP TABLE diu_users";
        $result = mysqli_query($this->conn, $query);

        if($result){
            echo "SUCCESS";
        }
        else{
            echo "failed";
        }*/
        /*$email = "monowaranjum@gmail.com";
        $this->setAdmin($email); */
    }

    }

?>