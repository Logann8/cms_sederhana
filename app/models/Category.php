<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM categories ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function createCategory($data) {
        $this->db->query('INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $this->createSlug($data['name']));
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function updateCategory($data) {
        $this->db->query('UPDATE categories SET name = :name, slug = :slug, description = :description WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', $this->createSlug($data['name']));
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    public function deleteCategory($id) {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    private function createSlug($name) {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
} 