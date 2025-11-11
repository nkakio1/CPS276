<?php
require_once 'Classes/Validation.php';
require_once 'Classes/Db_conn.php';
require_once 'Classes/Pdo_methods.php';

class StickyForm extends Validation {

    private PdoMethods $pdo;
    private array $form;
    private string $flashSuccess = '';
    private string $flashError   = '';

    public function __construct() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $this->pdo = new PdoMethods();

         $seed = $_SESSION['seed'] ?? null;
        if (isset($_SESSION['seed'])) unset($_SESSION['seed']);

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'POST') {
             $this->form = $this->getFormConfigEmpty();
        } else {
             $this->form = ($seed === 'empty')
                ? $this->getFormConfigEmpty()
                : $this->getFormConfigWithTestValues();
        }

         if (!empty($_SESSION['flashSuccess'])) {
            $this->flashSuccess = $_SESSION['flashSuccess'];
            unset($_SESSION['flashSuccess']);
        }
        if (!empty($_SESSION['flashError'])) {
            $this->flashError = $_SESSION['flashError'];
            unset($_SESSION['flashError']);
        }
    }

    public function handleRequest(array $post): void {
        if (!empty($post)) {
            $this->clearAllErrors($this->form);

            [$this->form, $success, $error] =
                $this->processRegistration($post, $this->pdo, $this->form);

            if ($success) {
                 $_SESSION['seed'] = 'empty';
                $_SESSION['flashSuccess'] = $success;

                header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
                exit;
            } elseif ($error) {
                 $this->flashError = $error;
            }
        }
    }

    private function getFormConfigWithTestValues(): array {
        return [
            'masterStatus' => ['error' => false],
            'firstName' => ['id'=>'first_name','name'=>'firstName','label'=>'First Name','type'=>'text','regex'=>'name','required'=>true,'value'=>'Kosei'],
            'lastName'  => ['id'=>'last_name','name'=>'lastName','label'=>'Last Name','type'=>'text','regex'=>'name','required'=>false,'value'=>'A'],
            'email'     => ['id'=>'email','name'=>'email','label'=>'Email','type'=>'text','regex'=>'email','required'=>true,'value'=>'koseia@wccnet.edu'],
            'password1' => ['id'=>'password1','name'=>'password1','label'=>'Password','type'=>'password','regex'=>'password','required'=>true,'value'=>'Password1!','errorMsg'=>'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)'],
            'password2' => ['id'=>'password2','name'=>'password2','label'=>'Confirm Password','type'=>'password','regex'=>'none','required'=>true,'value'=>'Password1!','errorMsg'=>'Your passwords do not match'],
        ];
    }

    private function getFormConfigEmpty(): array {
        return [
            'masterStatus' => ['error' => false],
            'firstName' => ['id'=>'first_name','name'=>'firstName','label'=>'First Name','type'=>'text','regex'=>'name','required'=>true,'value'=>''],
            'lastName'  => ['id'=>'last_name','name'=>'lastName','label'=>'Last Name','type'=>'text','regex'=>'name','required'=>false,'value'=>''],
            'email'     => ['id'=>'email','name'=>'email','label'=>'Email','type'=>'text','regex'=>'email','required'=>true,'value'=>''],
            'password1' => ['id'=>'password1','name'=>'password1','label'=>'Password','type'=>'password','regex'=>'password','required'=>true,'value'=>'','errorMsg'=>'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)'],
            'password2' => ['id'=>'password2','name'=>'password2','label'=>'Confirm Password','type'=>'password','regex'=>'none','required'=>true,'value'=>'','errorMsg'=>'Your passwords do not match'],
        ];
    }

    private function clearAllErrors(array &$form): void {
        if (isset($form['masterStatus'])) $form['masterStatus']['error'] = false;
        foreach ($form as &$el) {
            if (!is_array($el)) continue;
            if (array_key_exists('error', $el)) $el['error'] = '';
        }
    }

    private function validateForm($data, $form) {
        $this->clearAllErrors($form);

        foreach ($form as $key => &$element) {
            if (!is_array($element)) continue;

            $element['value'] = $data[$key] ?? ($element['value'] ?? '');
            $customErrorMsg = $element['errorMsg'] ?? null;

            if (isset($element['type']) && in_array($element['type'], ['text','textarea','password'], true) && isset($element['regex'])) {
                if (!empty($element['required']) && $element['value'] === '') {
                    $element['error'] = $customErrorMsg ?? 'This field is required.';
                    $form['masterStatus']['error'] = true;
                } elseif (!empty($element['required']) || $element['value'] !== '') {
                    $isValid = $this->checkFormat($element['value'], $element['regex'], $customErrorMsg);
                    if (!$isValid) {
                        $element['error'] = $this->getErrors()[$element['regex']] ?? ($customErrorMsg ?? 'Invalid value.');
                        $form['masterStatus']['error'] = true;
                    }
                }
            }

            if ($key === 'password2') {
                $cpw = $element['value'] ?? '';
                $pw  = $data['password1'] ?? ($form['password1']['value'] ?? '');
                if ($pw !== $cpw) {
                    $element['error'] = $customErrorMsg ?? 'Passwords do not match.';
                    $form['masterStatus']['error'] = true;
                }
            }
        }
        return $form;
    }

    private function processRegistration($data, $pdo, $form) {
        $form = $this->validateForm($data, $form);
        $flashSuccess = '';
        $flashError   = '';

        if (!$form['masterStatus']['error'] && !empty($data['email'])) {
            $sql  = "SELECT COUNT(*) AS c FROM users WHERE email = :email";
            $bind = [[":email", $data['email'], "str"]];
            $res  = $pdo->selectBinded($sql, $bind);
            if ($res === 'error' || intval($res[0]['c'] ?? 0) > 0) {
                $form['email']['error'] = 'Duplicate email.';
                $form['masterStatus']['error'] = true;
            }
        }

        if (!$form['masterStatus']['error']) {
            $hash = password_hash($data['password1'] ?? $form['password1']['value'] ?? '', PASSWORD_DEFAULT);
            $sql  = "INSERT INTO users (first_name,last_name,email,password_hash)
                     VALUES (:fn,:ln,:em,:pw)";
            $bind = [
                [':fn', $data['firstName'] ?? $form['firstName']['value'] ?? '', 'str'],
                [':ln', $data['lastName']  ?? $form['lastName']['value']  ?? '', 'str'],
                [':em', $data['email']     ?? $form['email']['value']     ?? '', 'str'],
                [':pw', $hash, 'str'],
            ];
            $status = $pdo->otherBinded($sql, $bind);

            if ($status !== 'error') {
                foreach ($form as &$f) {
                    if (!is_array($f)) continue;
                    if (array_key_exists('value', $f)) $f['value'] = '';
                    if (array_key_exists('error', $f)) $f['error'] = '';
                }
                $flashSuccess = 'You have been added to the database.';
            } else {
                $flashError = 'Addition failed, contact admin.';
            }
        }

        return [$form, $flashSuccess, $flashError];
    }

    public function v(string $key): string {
        return htmlspecialchars($this->form[$key]['value'] ?? '', ENT_QUOTES);
    }
    public function e(string $key): string {
        return !empty($this->form[$key]['error'])
            ? "<span class='text-danger'>{$this->form[$key]['error']}</span><br>"
            : '';
    }
    public function flashSuccess(): string {
        return $this->flashSuccess;
    }
    public function flashError(): string {
        return $this->flashError;
    }

    public function renderUserRowsOnly(): string {
        $rows = $this->pdo->selectNotBinded("SELECT first_name,last_name,email,password_hash FROM users ORDER BY id ASC");
        $html = '';
        if (is_array($rows)) {
            foreach ($rows as $r) {
                $html .= '<tr>'
                       . '<td>'.htmlspecialchars($r['first_name']).'</td>'
                       . '<td>'.htmlspecialchars($r['last_name']).'</td>'
                       . '<td>'.htmlspecialchars($r['email']).'</td>'
                       . '<td>'.htmlspecialchars($r['password_hash']).'</td>'
                       . '</tr>';
            }
        }
        return $html;
    }
}
