<?php
class Post {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllPosts() {
        $this->db->query('SELECT p.*, u.username as author_name, c.name as category_name 
                         FROM posts p 
                         LEFT JOIN users u ON p.author_id = u.id 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function getPostById($id) {
        $this->db->query('SELECT p.*, u.username as author_name, c.name as category_name 
                         FROM posts p 
                         LEFT JOIN users u ON p.author_id = u.id 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function createPost($data) {
        $this->db->query('INSERT INTO posts (title, slug, content, excerpt, author_id, category_id, status) 
                         VALUES (:title, :slug, :content, :excerpt, :author_id, :category_id, :status)');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $this->createSlug($data['title']));
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':excerpt', $data['excerpt']);
        $this->db->bind(':author_id', $data['author_id']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function updatePost($data) {
        $this->db->query('UPDATE posts 
                         SET title = :title, 
                             slug = :slug, 
                             content = :content, 
                             excerpt = :excerpt, 
                             category_id = :category_id, 
                             status = :status 
                         WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':slug', $this->createSlug($data['title']));
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':excerpt', $data['excerpt']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function deletePost($id) {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    private function createSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
} 