<?php

class Mysql
{
  public $conn;

  public function __construct()
  {
    $this->conn = mysqli_connect('db', 'root', 'root', 'unsecure');
    mysqli_set_charset($this->conn, 'utf-8');

    if ($this->conn->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->conn->connect_error;
      print_r(env('DB_HOST'));
      print_r(env('DB_USERNAME'));
      print_r(env('DB_PASSWORD'));
      print_r(env('DB_DATABASE'));
      exit();
    }
  }

  public function select($table, $query = '*', $where = [])
  {

    $sql = 'SELECT '.$query.' FROM '.$table;

    if($where) {
      $output = ' WHERE ';

      foreach ($where as $key => $q) {
        $where[$key] = $key." = '".$q."'";
      }

      $output .= implode(' AND ', $where);
      $sql .= $output;
    }

    $result = mysqli_multi_query($this->conn, $sql);

    if(!$result) return $result;

    $output = [];

    if ($result = $this->conn->store_result()) {
       while($row = mysqli_fetch_assoc($result)) {
          $output[] = $row;
       }
    }

    return $output;
  }

  public static function mapData($n)
  {
      $n = html_entity_decode(preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($n)), null, 'UTF-8');

        return "'".$n."'";
  }

  public function insert($table, $data)
  {

    $sql = 'INSERT INTO '.$table.' (';

    $values = array_values($data);
    $keys = array_keys($data);

    $values = array_map('self::mapData', $values);

    $sql .= implode(",", $keys).") VALUES (";
    $sql .= implode(",", $values).");";

    if ($this->conn->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }

  }

  public function boot()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `articles` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(235) NOT NULL,
      `content` varchar(235) NOT NULL,
      `author` varchar(235) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

    $sql = "CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `email` varchar(235) NOT NULL,
      `password` varchar(235) NOT NULL,
      `role` varchar(235) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";


    $result = mysqli_multi_query($this->conn, $sql);
  }

  public function __destruct()
  {
     mysqli_close($this->conn);
  }
}
