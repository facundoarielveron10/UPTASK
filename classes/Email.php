<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    // Atributos
    protected $email;
    protected $nombre;
    protected $token;

    // Constructor
    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    // Metodos
    // Envia un mail de confirmacion al usuario
    public function enviarConfirmacion() {
        // Configurar PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '20c9e767679b2f';
        $mail->Password = 'dd4c20ee5340b6';
        $mail->Subject = 'Confirma tu Cuenta';

        // Definimos datos del remitente
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');

        // Hacemos el cuerpo del mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has Creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>';
        $contenido .= '<p>Presiona aqui: <a href="http://' . $_SERVER["HTTP_HOST"] . '/confirmar?token=' . $this->token . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';
        
        $mail->Body = $contenido;
        
        // Enviar el Email
        $mail->send();
    }

    // Envia un mail para reestablecer la contraseña al usuario
    public function enviarInstrucciones() {
        // Configurar PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '20c9e767679b2f';
        $mail->Password = 'dd4c20ee5340b6';
        $mail->Subject = 'Reestablecer contraseña';

        // Definimos datos del remitente
        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');

        // Hacemos el cuerpo del mail
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong> Has pedido reestablecer tu contraseña en UpTask, solo debes reestablecerla en el siguiente enlace</p>';
        $contenido .= '<p>Presiona aqui: <a href="http://' . $_SERVER["HTTP_HOST"] . '/reestablecer?token=' . $this->token . '">Reestablecer contraseña</a></p>';
        $contenido .= '<p>Si tu no pediste reestablecer tu contraseña, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';
        
        $mail->Body = $contenido;
        
        // Enviar el Email
        $mail->send();
    }
}