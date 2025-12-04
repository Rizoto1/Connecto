<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\User;
use App\Models\Post;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class ProfileController extends BaseController
{
    public function index(Request $request): Response
    {
        // Require logged in user
        if (!$this->user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        /** @var User $identity */
        $identity = $this->user->getIdentity();
        $message = null;
        $success = null;

        if ($request->isPost() && $request->hasValue('submit')) {
            // Read incoming values
            $newName = trim((string)$request->value('username'));
            $newEmail = trim((string)$request->value('email'));
            $newPassword = (string)$request->value('password'); // optional; if empty, skip change

            $errors = [];

            // Username simple validation
            if ($newName === '') {
                $errors[] = 'Používateľské meno nemôže byť prázdne.';
            }

            // Email validation (same as in AuthController)
            $basicValid = filter_var($newEmail, FILTER_VALIDATE_EMAIL) !== false;
            $shapeValid = (bool)preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/', $newEmail);
            if (!$basicValid || !$shapeValid) {
                $errors[] = 'Neplatný e-mail – zadajte úplnú adresu (napr. meno@example.com).';
            }

            // Ensure email uniqueness if changed
            if ($newEmail !== $identity->getEmail()) {
                if (User::getCount('email = ?', [$newEmail]) > 0) {
                    $errors[] = 'Užívateľ s touto e-mailovou adresou už existuje.';
                }
            }

            // Validate password only if provided
            $passwordHash = null;
            if ($newPassword !== '') {
                $passwordOk = (bool)preg_match('/^(?=.*\d)(?=.*[^A-Za-z0-9\s]).{8,}$/', $newPassword);
                if (!$passwordOk) {
                    $errors[] = 'Heslo je neplatné – musí mať aspoň 8 znakov a obsahovať číslo aj špeciálny znak (napr. . , ! ?).';
                } else {
                    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
                }
            }

            // Handle avatar upload (optional)
            $uploaded = $request->file('avatar');
            $newAvatarRel = null; // relative web path like uploads/filename.jpg
            if ($uploaded !== null) {
                if ($uploaded->isOk()) {
                    $type = strtolower($uploaded->getType());
                    if (!str_starts_with($type, 'image/')) {
                        $errors[] = 'Nahraný súbor musí byť obrázok.';
                    } else {
                        $uploadsDir = __DIR__ . '/../../public/uploads';
                        if (!is_dir($uploadsDir)) {
                            @mkdir($uploadsDir, 0777, true);
                        }
                        $ext = pathinfo($uploaded->getName(), PATHINFO_EXTENSION);
                        $safeExt = preg_replace('/[^a-z0-9]+/i', '', $ext) ?: 'img';
                        $fileName = uniqid('avatar_', true) . '.' . $safeExt;
                        $targetPath = $uploadsDir . DIRECTORY_SEPARATOR . $fileName;
                        if ($uploaded->store($targetPath)) {
                            $newAvatarRel = 'uploads/' . $fileName;
                        } else {
                            $errors[] = 'Nepodarilo sa uložiť profilový obrázok.';
                        }
                    }
                } elseif ($uploaded->getError() !== UPLOAD_ERR_NO_FILE) {
                    $msg = $uploaded->getErrorMessage();
                    if ($msg) {
                        $errors[] = $msg;
                    }
                }
            }

            if (!$errors) {
                // Update identity fields
                $identity->setName($newName);
                $identity->setEmail($newEmail);
                if ($passwordHash !== null) {
                    $identity->setPasswordHash($passwordHash);
                }
                if ($newAvatarRel !== null) {
                    $identity->setAvatar($newAvatarRel);
                }
                // Persist to DB
                $identity->save();

                // Refresh session identity so changes are reflected
                $this->app->getSession()->set(Configuration::IDENTITY_SESSION_KEY, $identity);

                $success = 'Profil bol úspešne aktualizovaný.';
            } else {
                $message = implode("\n", $errors);
            }
        }

        // Render with current values
        $data = [
            'user' => $identity,
            'message' => $message,
            'success' => $success,
        ];
        return $this->html($data);
    }

    public function post(Request $request): Response
    {
        // Ensure the user is logged in
        if (!$this->user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        /** @var User $identity */
        $identity = $this->user->getIdentity();
        $uid = $identity?->getId();

        $posts = [];
        if ($uid !== null) {
            try {
                // Preferred: filter by author
                $posts = Post::getAll('userId = ?', [$uid], 'createdAt DESC');
            } catch (\Throwable $e) {
                // Fallback if the column does not exist in DB yet
                $posts = Post::getAll(orderBy: 'createdAt DESC');
            }
        }

        return $this->html([
            'user' => $identity,
            'posts' => $posts,
        ], 'post');
    }
}