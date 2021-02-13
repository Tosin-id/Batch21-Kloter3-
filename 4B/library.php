<?php
class Library
{
    public function __construct()
    {
        $host = "localhost";
        $dbname = "db_article";
        $username = "root";
        $password = "";
        $this->db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }


    public function show()
    {
        $query = $this->db->prepare("SELECT users_tb.name, users_tb.photo, users_tb.email, users_tb.password, post_tb.id, post_tb.content, post_tb.image, post_tb.id_user FROM users_tb, post_tb WHERE users_tb.id=post_tb.id_user");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }
}
