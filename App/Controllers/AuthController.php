<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\User;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $message = null;

        if ($request->hasValue('submit')) {
            // Read email and password from request
            $email = trim((string)$request->value('email'));
            $password = (string)$request->value('password');

            // Basic sanity check for email input
            $basicValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            $shapeValid = (bool)preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/', $email);
            if (!$basicValid || !$shapeValid) {
                $message = 'Neplatný e-mail – zadajte úplnú adresu (napr. meno@example.com).';
                return $this->html(compact('message'));
            }

            // Try to find user by email (limit 1)
            $users = User::getAll('email = ?', [$email], null, 1);
            $user = $users[0] ?? null;

            if ($user instanceof User && $user->getPasswordHash() !== null) {
                // Verify password against stored hash
                if (password_verify($password, $user->getPasswordHash())) {
                    // Manually set identity in session to work with SessionAuthenticator/DummyAuthenticator
                    $this->app->getSession()->set(Configuration::IDENTITY_SESSION_KEY, $user);
                    return $this->redirect($this->url('post.index'));
                }
            }

            // If DB-based auth failed, optionally fall back to configured authenticator (e.g., DummyAuthenticator)
            // This allows logging in with hardcoded credentials if enabled in configuration.
            $auth = $this->app->getAuthenticator();
            if ($auth !== null) {
                // For backward compatibility: some authenticators may expect "username"; we pass email here.
                if ($auth->login($email, $password)) {
                    return $this->redirect($this->url('post.index'));
                }
            }

            $message = 'Bad email or password';
        }

        return $this->html(compact('message'));
    }

    public function register(Request $request): Response
    {
        if ($request->hasValue('submit')) {
            $email = trim((string)$request->value('email'));
            $password = (string)$request->value('password');

            // 0) Robust email validation: must be a full address (e.g., aaa@gmail.com)
            $basicValid = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            $shapeValid = (bool)preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/', $email);
            if (!$basicValid || !$shapeValid) {
                $message = "Neplatný e-mail – zadajte úplnú adresu (napr. meno@example.com).";
                return $this->html(compact('message'));
            }

            // 1) Check if user with this email already exists
            if (User::getCount('email = ?', [$email]) > 0) {
                $message = 'Užívateľ s touto e-mailovou adresou už existuje.';
                return $this->html(compact('message'));
            }

            // 2) Validate password strength: min 8 chars, at least one digit and one special (non-alphanumeric) char
            $passwordOk = (bool)preg_match('/^(?=.*\d)(?=.*[^A-Za-z0-9\s]).{8,}$/', $password);
            if (!$passwordOk) {
                $message = 'Heslo je neplatné – musí mať aspoň 8 znakov a obsahovať číslo aj špeciálny znak (napr. . , ! ?).';
                return $this->html(compact('message'));
            }

            // Passed validation – create user
            $user = new User();
            $user->setName((string)$request->value('username'));
            $user->setPasswordHash(password_hash($password, PASSWORD_BCRYPT));
            $user->setEmail($email);
            // Set createdAt as string (ISO 8601)
            $user->setCreatedAt(date('c'));

            $user->save();

            // Optional: redirect to login after successful registration
            return $this->redirect(Configuration::LOGIN_URL);
        }

        return $this->html();
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuthenticator()->logout();
        return $this->html();
    }
}
