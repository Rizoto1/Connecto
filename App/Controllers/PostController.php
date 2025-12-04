<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment; // added
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;

class PostController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        // Allow all actions for now; integrate auth later if needed
        return true;
    }

    public function index(Request $request): Response
    {
        $posts = Post::getAll(orderBy: 'createdAt DESC');
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

            // Handle image upload if present
            $uploaded = $request->file('image');
            if ($uploaded !== null && $uploaded->isOk()) {
                $type = strtolower($uploaded->getType());
                if (!str_starts_with($type, 'image/')) {
                    $errors[] = 'Uploaded file must be an image';
                } else {
                    // Ensure uploads directory exists under public
                    $uploadsDir = __DIR__ . '/../../public/uploads';
                    if (!is_dir($uploadsDir)) {
                        @mkdir($uploadsDir, 0777, true);
                    }
                    // Generate a safe unique filename
                    $ext = pathinfo($uploaded->getName(), PATHINFO_EXTENSION);
                    $safeExt = preg_replace('/[^a-z0-9]+/i', '', $ext) ?: 'img';
                    $fileName = uniqid('post_', true) . '.' . $safeExt;
                    $targetPath = $uploadsDir . DIRECTORY_SEPARATOR . $fileName;
                    if ($uploaded->store($targetPath)) {
                        // Save relative path for serving via LinkGenerator asset
                        $post->setImage('uploads/' . $fileName);
                    } else {
                        $errors[] = 'Failed to store uploaded image';
                    }
                }
            } elseif ($uploaded !== null && !$uploaded->isOk()) {
                // If a file was attempted but failed, include error message unless it's "no file"
                $msg = $uploaded->getErrorMessage();
                if ($uploaded->getError() !== UPLOAD_ERR_NO_FILE && $msg) {
                    $errors[] = $msg;
                }
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

    // New action: add a comment to a post
    public function addComment(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->redirect($this->url('index'));
        }

        // Enforce authentication: guests cannot add comments
        if (!$this->user->isLoggedIn()) {
            // Redirect to login URL defined in configuration
            return $this->redirect(\App\Configuration::LOGIN_URL);
        }

        $postId = (int)($request->post()['postId'] ?? 0);
        $content = trim((string)($request->post()['content'] ?? ''));

        $errors = [];
        if ($postId <= 0 || Post::getOne($postId) === null) {
            $errors[] = 'Invalid post';
        }
        if ($content === '') {
            $errors[] = 'Komentár nemôže byť prázdny';
        }

        if ($errors) {
            // Simple approach: redirect back to index; in future we can flash errors
            return $this->redirect($this->url('index'));
        }

        /** @var Comment $comment */
        $comment = new Comment();
        $comment->setPostId($postId);
        // attach user (we already know user is logged in)
        $uid = $this->user->getIdentity()?->getId();
        if (is_int($uid)) {
            $comment->setUserId($uid);
        }
        $comment->setContent($content);
        if (method_exists($comment, 'setCreatedAt')) {
            $comment->setCreatedAt(date('Y-m-d H:i:s'));
        }
        $comment->save();

        return $this->redirect($this->url('index'));
    }
}

