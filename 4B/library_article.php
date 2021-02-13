<?php
class LibraryArticle
{
    public function __construct()
    {
        $host = "localhost";
        $dbname = "db_article";
        $username = "root";
        $password = "";
        $this->db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }
    public function add_article($title, $content, $image, $created_at, $id_user, $id_category)
    {
        $data = $this->db->prepare('INSERT INTO article (title, content, image, created_at, id_user, id_category) VALUES (?, ?, ?, ?, ?, ?)');
        $data->bindParam(1, $title);
        $data->bindParam(2, $content);
        $data->bindParam(3, $image);
        $data->bindParam(4, $created_at);
        $data->bindParam(5, $id_user);
        $data->bindParam(6, $id_category);

        $data->execute();
        return $data->rowCount();
    }

    public function show()
    {
        $query = $this->db->prepare("SELECT article.id, article.title, article.content, article.image, article.created_at, author.name as author, category.name as category FROM article, author, category  WHERE article.id_user = author.id AND article.id_category = category.id ;");
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_by_id($id)
    {
        $query = $this->db->prepare("SELECT article.id, article.title, article.content, article.image, article.created_at, author.name as author, category.name as category FROM article, author, category  WHERE article.id_user = author.id AND article.id_category = category.id AND article.id=?");
        $query->bindParam(1, $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_by_user_id($id)
    {
        $query = $this->db->prepare("SELECT article.id, article.title, article.content, article.image, article.created_at, author.name as author, category.name as category FROM article, author, category  WHERE article.id_user = author.id AND article.id_category = category.id AND article.id_user=?");
        $query->bindParam(1, $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_by_category_id($id)
    {
        $query = $this->db->prepare("SELECT article.id, article.title, article.content, article.image, article.created_at, author.name as author, category.name as category FROM article, author, category  WHERE article.id_user = author.id AND article.id_category = category.id AND article.id_category=?");
        $query->bindParam(1, $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }

    public function get_image($id)
    {
        $query = $this->db->prepare("SELECT image FROM article WHERE id=?");
        $query->bindParam(1, $id);
        $query->execute();
        $data = $query->fetchAll();
        return $data;
    }


    public function update($id, $title, $content, $image, $created_at, $id_user, $id_category)
    {
        $query = $this->db->prepare('UPDATE article SET title=?, content=?, image=?, created_at=?, id_user=?, id_category=?  WHERE id=?');

        $query->bindParam(1, $title);
        $query->bindParam(2, $content);
        $query->bindParam(3, $image);
        $query->bindParam(4, $created_at);
        $query->bindParam(5, $id_user);
        $query->bindParam(6, $id_category);
        $query->bindParam(7, $id);

        $query->execute();
        return $query->rowCount();
    }

    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM article where id=?");

        $query->bindParam(1, $id);

        $query->execute();
        return $query->rowCount();
    }
}
