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
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    // Metodos
    // Validacion para cuentas nuevas
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del usuario es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email del usuario es Obligatorio';
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
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un token
    public function crearToken() {
        $this->token = uniqid();
    }

    // Valida el email del usuario
    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }

        return self::$alertas;
    }

    // Valida el password
    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password no puede ir vacio';
        }
        if (strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
        
        return self::$alertas;
    }

    // Valida los datos ingresados en el login
    public function validarLogin() {
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
}
