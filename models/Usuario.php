<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    // Constructor
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Metodos
    // Validacion para cuentas nuevas
    public function validarNuevaCuenta() : array {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del usuario es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email del usuario es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = "Los password son diferentes";
        }

        return self::$alertas;
    }

    // Hashear el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Comprobar el password actual del usuari
    public function comprobarPassword() : bool {
        return password_verify($this->password_actual, $this->password);
    }

    // Creamos un nuevo password para el usuario
    public function nuevoPassword() : array {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Nuevo Password no puede ir vacio';
        }
        if (strlen($this->password_nuevo) < 8) {
            self::$alertas['error'][] = 'El Nuevo Password debe contener al menos 8 caracteres';
        }

        return self::$alertas;
    }

    // Generar un token
    public function crearToken() : void {
        $this->token = uniqid();
    }

    // Valida el email del usuario
    public function validarEmail() : array {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }

        return self::$alertas;
    }

    // Valida el password
    public function validarPassword() : array {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
        
        return self::$alertas;
    }

    // Valida los datos ingresados en el login
    public function validarLogin() : array {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }

        return self::$alertas;
    }

    // Valida el perfil del usuario al editarlo
    public function validarPerfil() : array {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }

        return self::$alertas;
    }
}
