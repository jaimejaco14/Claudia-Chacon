<?php
//include 'conexon.php';
if ($id == $_POST['id_usuario']) {
        $sql = "UPDATE usuarios  SET nombre = ?, direccion = ?, telefono = ?, email = ?, contrasena = ? WHERE id_usuario = ?";
        $query = $pdo->prepare($sql);
        if ($query->execute(array($nombre, $direccion, $telefono, $email, $pwd, intval($id_usuario))) == false) {
            $msg = 'Error: ' . $query->errorCode();
        } else {
            $msg = 'Usuario Actualizado';
        }
    }