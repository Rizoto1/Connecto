<?php

namespace App\Controllers;

use App\Models\Post;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class PostController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        // Allow all actions for now; integrate auth later if needed
        return true;
    }

    public function index(Request $request): Response
    {
        // List posts
        //orderBy: 'createdAt DESC'
        $posts = Post::getAll();
        return $this->html(['posts' => $posts]);
    }

    public function create(Request $request): Response
    {
        if ($request->isPost()) {
            $post = new Post();
            $post->setFromRequest($request);
            // Basic validation
            $errors = [];
            if (empty(trim($post->getTitle() ?? ''))) {
                $errors[] = 'Title is required';
            }
            if (empty(trim($post->getContent() ?? ''))) {
                $errors[] = 'Content is required';
            }
            if ($errors) {
                return $this->html(['errors' => $errors, 'old' => $request->post()], 'create');
            }
            $post->setCreatedAt(date('Y-m-d H:i:s'));
            $post->save();
            return $this->redirect($this->url('index'));
        }
        return $this->html([], 'create');
    }

    public function show(Request $request): Response
    {
        $id = (int)($request->get()['id'] ?? 0);
        $post = Post::getOne($id);
        if ($post === null) {
            // simple fallback: redirect to index
            return $this->redirect($this->url('index'));
        }
        return $this->html(['post' => $post]);
    }

    public function delete(Request $request): Response
    {
        $id = (int)($request->post()['id'] ?? 0);
        $post = Post::getOne($id);
        if ($post) {
            $post->delete();
        }
        return $this->redirect($this->url('index'));
    }
}
