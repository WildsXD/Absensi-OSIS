<?php
include '../database/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user     = trim($_POST['emailNis'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors   = [];

    if (empty($user) || empty($password)) {
        $errors[] = 'Email/NIS dan password wajib diisi!';
    } else {
        $login = $conn->prepare('SELECT * FROM users WHERE nis = ? OR email = ? LIMIT 1');
        $login->bind_param('ss', $user, $user);
        $login->execute();
        $result = $login->get_result();
        $data   = $result->fetch_assoc();

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['user_id']      = $data['id'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['role']         = $data['role'];        // Redirect sesuai role
            if ($data['role'] === 'admin') {
                header('Location: ../pages/admin/dashboard-admin.php');
            } else {
                header('Location: ../pages/member/dashboard-member.php');
            }
            exit;
        } else {
            $errors[] = 'Email/NIS atau password salah!';
        }

        $login->close();
    }

    $_SESSION['login_errors'] = $errors;
    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../index.php');
    exit;
}
