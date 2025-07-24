<?php
require_once __DIR__ . '/../config/config.php';

class App
{
    public $host = HOST;
    public $dbname = DBNAME;
    public $user = USER;
    public $pass = PASS;
    public $link;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->link = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->pass
            );
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database Connection Failed: ' . $e->getMessage());
        }
    }

    // Select all matching rows, returns array of objects or false
    public function selectAll(string $query)
    {
        $stmt = $this->link->query($query);
        if ($stmt) {
            $allRows = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $allRows ?: false;
        }
        return false;
    }

    // Select one row, optionally with parameters, returns object or false
    public function selectOne(string $query, array $params = [])
    {
        $stmt = $this->link->prepare($query);
        $stmt->execute($params);
        $singleRow = $stmt->fetch(PDO::FETCH_OBJ);
        return $singleRow ?: false;
    }

    /**
     * Count rows of a given query.
     * Used similarly to validateCart functionality in your first snippet.
     * Returns count of rows.
     */
    public function validateCart(string $query)
    {
        $stmt = $this->link->query($query);
        if ($stmt) {
            return $stmt->rowCount();
        }
        return 0;
    }

    // Returns "empty" if any input is empty, otherwise "ok"
    public function validate(array $arr): string
    {
        return in_array("", $arr, true) ? "empty" : "ok";
    }

    // Insert with parameters; alerts if validation fails or redirects on success
    public function insert(string $query, array $arr, string $path)
    {
        if ($this->validate($arr) === "empty") {
            echo "<script>alert('One or more inputs are empty')</script>";
            return;
        }
        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        echo "<script>window.location.href='" . $path . "'</script>";
        exit();
    }

    // Update with parameters; alerts if validation fails or redirects on success
    public function update(string $query, array $arr, string $path)
    {
        if ($this->validate($arr) === "empty") {
            echo "<script>alert('One or more inputs are empty')</script>";
            return;
        }
        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        header("Location: " . $path);
        exit();
    }

    // Delete based on query (no params); redirects on success
    public function delete(string $query, string $path)
    {
        $stmt = $this->link->query($query);
        if ($stmt) {
            // Note: $stmt->execute() unnecessary after query()
            echo "<script>window.location.href='" . $path . "'</script>";
            exit();
        }
        // Optionally handle delete failure here
    }

    // Register user with validation and duplicate email check
    public function register(string $query, array $arr, string $path)
    {
        if ($this->validate($arr) === "empty") {
            echo "<script>alert('One or more inputs are empty')</script>";
            return;
        }

        // Check for existing email
        $checkStmt = $this->link->prepare("SELECT id FROM users WHERE email = :email");
        $checkStmt->execute(['email' => $arr['email']]);
        if ($checkStmt->rowCount() > 0) {
            echo "<script>alert('Email already registered!')</script>";
            return;
        }

        $stmt = $this->link->prepare($query);
        $stmt->execute($arr);
        header("Location: " . $path);
        exit();
    }

    // Login user: accepts query with placeholder(s), data array, and redirect path
    public function login(string $query, array $data, string $path)
    {
        $stmt = $this->link->prepare($query);

        // Extract named placeholders from the query (e.g., :email, :password)
        preg_match_all('/:\w+/', $query, $matches);
        $placeholders = $matches[0]; // array of placeholders with ':' prefix

        // Build execute params array matching placeholders in $data
        $executeParams = [];
        foreach ($placeholders as $placeholder) {
            // Remove ":" to get the key
            $key = ltrim($placeholder, ':');
            if (!isset($data[$key])) {
                // Parameter missing in $data - handle error or throw exception
                throw new InvalidArgumentException("Missing parameter '$key' for login query.");
            }
            $executeParams[$key] = $data[$key];
        }

        // Execute with all placeholders bound
        $stmt->execute($executeParams);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: " . $path);
            exit();
        } else {
            echo "<script>alert('Invalid login credentials')</script>";
        }
    }

    // Manually start session if not started yet
    public function startingSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Redirect logged-in users away from login/register pages to APPURL
    public function validateSession()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . APPURL);
            exit();
        }
    }

    // Redirect logged-in admins to admin dashboard
    public function validateSessionAdmin()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . ADMINURL . "/index.php");
            exit();
        }
    }

    // Redirect guests trying to access admin pages to admin login
    public function validateSessionAdminInside()
    {
        if (!isset($_SESSION['email'])) {
            header("Location: " . ADMINURL . "/admins/login-admins.php");
            exit();
        }
    }
}
