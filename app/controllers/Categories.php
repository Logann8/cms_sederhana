<?php
class Categories extends Controller {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        
        $data = [
            'title' => 'Categories',
            'categories' => $categories
        ];

        $this->view('templates/header', $data);
        $this->view('categories/index', $data);
        $this->view('templates/footer');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];

            if ($this->categoryModel->createCategory($data)) {
                redirect('categories');
            } else {
                $this->view('categories/create', $data);
            }
        } else {
            $data = [
                'title' => 'Create Category',
                'name' => '',
                'description' => ''
            ];

            $this->view('templates/header', $data);
            $this->view('categories/create', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];

            if ($this->categoryModel->updateCategory($data)) {
                redirect('categories');
            } else {
                $this->view('categories/edit', $data);
            }
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            
            $data = [
                'title' => 'Edit Category',
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description
            ];

            $this->view('templates/header', $data);
            $this->view('categories/edit', $data);
            $this->view('templates/footer');
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->categoryModel->deleteCategory($id)) {
                redirect('categories');
            }
        } else {
            redirect('categories');
        }
    }
} 