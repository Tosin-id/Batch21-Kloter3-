<?php
class LibraryAuthor
{
    public function __construct()
    {
        $host = "localhost";
        $dbname = "db_article";
        $username = "root";
        $password = "";
        $this->db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }
    public function add_author($name, $email, $password, $image)
    {
        $data = $this->db->prepare('INSERT INTO author (name, email, password, image) VALUES ( ?, ?, ?, ?)');

        $data->bindParam(1, $name);
        $data->bindParam(2, $email);
        $data->bindParam(3, $password);
        $data->bindParam(4, $image);

        $data->execute();
        return $data->rowCount();
    }

    public function show()
    {
        $query = $this->db->prepare("SELECT * FROM author");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_by_id($id)
    {
        $query = $this->db->prepare("SELECT * FROM author where id=?");
        $query->bindParam(1, $id);
        $query->execute();
        $data = $query->fetch();
        return $data;
    }

    public function get_id($name)
    {
        $query = $this->db->prepare("SELECT id FROM author where name=?");
        $query->bindParam(1, $name);
        $query->execute();
        $data = $query->fetch();
        return $data;
    }


    public function get_by_email($email)
    {
        $query = $this->db->prepare("SELECT * FROM author where email= :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $data = $query->fetch();
        return $data;
    }

    public function update($id, $name, $email, $password, $image)
    {
        $query = $this->db->prepare('UPDATE author set name=?, email=?, password=?, image=? where id=?');

        $query->bindParam(1, $name);
        $query->bindParam(2, $email);
        $query->bindParam(3, $password);
        $query->bindParam(4, $image);
        $query->bindParam(5, $id);

        $query->execute();
        return $query->rowCount();
    }

    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM author where id=?");

        $query->bindParam(1, $id);

        $query->execute();
        return $query->rowCount();
    }
}
