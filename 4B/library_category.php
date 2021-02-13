<?php
class LibraryCategory
{
    public function __construct()
    {
        $host = "localhost";
        $dbname = "db_article";
        $username = "root";
        $password = "";
        $this->db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }
    public function add_category($name)
    {
        $data = $this->db->prepare('INSERT INTO category (name) VALUES (?)');
        $data->bindParam(1, $name);

        $data->execute();
        return $data->rowCount();
    }

    public function show()
    {
        $query = $this->db->prepare("SELECT * FROM category");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_by_id($id)
    {
        $query = $this->db->prepare("SELECT * FROM category where id=?");
        $query->bindParam(1, $id);
        $query->execute();
        return $query->fetch();
    }

    public function get_id($category)
    {
        $query = $this->db->prepare("SELECT id FROM category where name=?");
        $query->bindParam(1, $category);
        $query->execute();
        return $query->fetch();
    }


    public function update($id, $name)
    {
        $query = $this->db->prepare('UPDATE category set name=? where id=?');

        $query->bindParam(1, $name);
        $query->bindParam(2, $id);

        $query->execute();
        return $query->rowCount();
    }

    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM category where id=?");

        $query->bindParam(1, $id);

        $query->execute();
        return $query->rowCount();
    }
}
