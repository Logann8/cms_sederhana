<?php
class Posts extends Controller {
    private $postModel;

    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    public function index() {
        $posts = $this->postModel->getAllPosts();
        
        $data = [
            'title' => 'Posts',
            'posts' => $posts
        ];

        $this->view('templates/header', $data);
        $this->view('posts/index', $data);
        $this->view('templates/footer');
    }

    public function show($id) {
        $post = $this->postModel->getPostById($id);
        
        $data = [
            'title' => $post->title,
            'post' => $post
        ];

        $this->view('templates/header', $data);
        $this->view('posts/show', $data);
        $this->view('templates/footer');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'excerpt' => trim($_POST['excerpt']),
                'author_id' => $_SESSION['user_id'],
                'category_id' => trim($_POST['category_id']),
                'status' => trim($_POST['status'])
            ];

            if ($this->postModel->createPost($data)) {
                redirect('posts');
            } else {
                $this->view('posts/create', $data);
            }
        } else {
            $data = [
                'title' => 'Create Post',
                'title' => '',
                'content' => '',
                'excerpt' => '',
                'category_id' => '',
                'status' => 'draft'
            ];

            $this->view('templates/header', $data);
            $this->view('posts/create', $data);
            $this->view('templates/footer');
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'excerpt' => trim($_POST['excerpt']),
                'category_id' => trim($_POST['category_id']),
                'status' => trim($_POST['status'])
            ];

            if ($this->postModel->updatePost($data)) {
                redirect('posts');
            } else {
                $this->view('posts/edit', $data);
            }
        } else {
            $post = $this->postModel->getPostById($id);
            
            $data = [
                'title' => 'Edit Post',
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'excerpt' => $post->excerpt,
                'category_id' => $post->category_id,
                'status' => $post->status
            ];

            $this->view('templates/header', $data);
            $this->view('posts/edit', $data);
            $this->view('templates/footer');
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($id)) {
                redirect('posts');
            }
        } else {
            redirect('posts');
        }
    }
} 