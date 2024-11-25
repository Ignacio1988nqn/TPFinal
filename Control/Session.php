<?php

class Session
{

    public function __construct()
    {
        if (!self::activa()) {
            session_start();
        }
    }


    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $obj = new ABMUsuario();

        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        $param['usdeshabilitado'] = null;

        $resultado = $obj->buscar($param);
        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $_SESSION['idusuario'] = $usuario->getIdUsuario();

            // Maneja los roles en caso de que sean dos o más
            $abmUsuarioRol = new ABMUsuarioRol();
            $idUsuario = $_SESSION['idusuario'];
            $roles = $abmUsuarioRol->buscar(['idusuario' => $idUsuario]);

            if (count($roles) > 1) {
                $_SESSION['roles'] = $roles;
                // manda un JSON
                echo json_encode([
                    "success" => true,
                    "redirect" => "../accion/seleccionarRol.php",
                    "message" => "Inicio de sesión exitoso. Seleccione un rol."
                ]);
                exit();
            }

            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }
    

    



    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
        return $resp;
    }


    public static function activa()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }


    public function getUsuario()
    {
        $usuario = null;

        if ($this->validar()) {
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }


    public function getRol()
    {
        $list_rol = null;
        if ($this->validar()) {
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->darRoles($param);
            if (count($resultado) > 0) {
                $list_rol = $resultado;
            }
        }
        return $list_rol;
    }


    public function cerrar()
    {
        $resp = true;
        session_destroy();
        //$_SESSION['idusuario']=null;
        return $resp;
    }

    public function setRoles($roles)
    {
        $_SESSION['roles'] = $roles;
    }

    //setea en caso de mas de un rol seleccionado 
    public function setRol($rol)
    {
        $_SESSION['rolSelec'] = $rol;
    }

    //obtiene el valor de un rol seleccionado en caso de mas de un rol
    public function getRolSelec()
    {
        $rol = null;
        if (isset($_SESSION['rolSelec'])) {
            $rol = $_SESSION['rolSelec'];
        }
        return $rol;
    }


    // get y set para el codigo de verif
    public function setCodVerif($codigo, $codigoVal)
    {
        $_SESSION[$codigo] = $codigoVal;
    }
    public function getCodVerif($codigo)
    {
        return $_SESSION[$codigo] ?? null;
    }

    // vaciar campo del codigo
    public function remover($codigo)
    {
        unset($_SESSION[$codigo]);
    }

    public function verificarLoginUsuario($datos) {
        $response = [
            "success" => false,
            "message" => ""
        ];
    
        if (isset($datos["usnombre"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
            
            $nombreUsuario = $datos["usnombre"];
            $passwordHash = $datos["uspass"];
    
            if ($this->iniciar($nombreUsuario, $passwordHash)) {
                $usuario = $this->getUsuario();
    
                if ($usuario->getUsDeshabilitado()) {
                    $response["message"] = "Usuario deshabilitado, no puede iniciar sesión.";
                } else {
                    $roles = $this->getRol();
                    $cantidadRoles = count($roles);
    
                    if ($cantidadRoles >= 1 ) {
                        $rol = $roles[0]->getIdRol();
                        $response = [
                            "success" => true,
                            "redirect" => match ($rol) {
                                1 => "../home/home.php",
                                2 => "../administracion/admin.php",
                                3 => "../deposito/depo.php",
                                default => "../home/home.php",
                            },
                            "message" => "Inicio de sesión exitoso."
                        ];
                    } else {
                        $response["message"] = "No se han encontrado roles para este usuario.";
                    }
                }
            } else {
                $response["message"] = "Usuario o contraseña incorrectos.";
            }
        } else {
            $response["message"] = "Datos inválidos.";
        }
        return $response;
    }
        
    public function verificarRegistroUsuario($datos) {
        $response = [
            "success" => false,
            "mensaje" => ""
        ];
    
        if (isset($datos["usnombre"]) && isset($datos["usmail"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
            $nombreUsuario = $datos["usnombre"];
            $password = $datos["uspass"];
            $mail = $datos["usmail"];
            $codigo = $datos["codigo"];
    
            if (empty($codigo)) {
                $response["mensaje"] = "Código de verificación incorrecto.";
            } elseif (strlen($password) < 8) {
                $response["mensaje"] = "La contraseña debe tener al menos 8 caracteres.";
            } elseif (strlen($nombreUsuario) < 5) {
                $response["mensaje"] = "El usuario debe tener al menos 5 caracteres.";
            } else {
                $usuarioExistente = new ABMUsuario();
                $usuarioEncontrado = $usuarioExistente->buscar(['usnombre' => $nombreUsuario]);
    
                if (!empty($usuarioEncontrado)) {
                    $response["mensaje"] = "El nombre de usuario ya está registrado. Por favor elige otro.";
                } else {
                    
                    $mailUsEncontrado = $usuarioExistente->buscar(['usmail' => $mail]);
                    if (!empty($mailUsEncontrado)) {
                        $response["mensaje"] = "El mail ya está registrado. Por favor elige otro.";
                    } else {
                        
                        $captcha = md5($codigo);
                        $codigoVerificacion = $this->getCodVerif('codigo_verificacion');
    
                        if ($codigoVerificacion !== $captcha) {
                            $this->remover('codigo_verificacion');
                            $response["mensaje"] = "Código de verificación incorrecto.";
                        } else {
                            $this->cerrar();
    
                            $datos['accion'] = 'nuevo';
                            $datos['usdeshabilitado'] = null;
    
                            $nuevoUsuario = new ABMUsuario();
                            $resp = $nuevoUsuario->abm($datos);
    
                            if ($resp) {
                                $ultimoUsuario = $nuevoUsuario->buscar(['usnombre' => $datos['usnombre']]);
                                if (!empty($ultimoUsuario)) {
                                    $idUsuario = $ultimoUsuario[0]->getIdUsuario();
    
                                    $datosRol = [
                                        'accion' => 'asignar_rol',
                                        'idusuario' => $idUsuario,
                                        'idrol' => 1,
                                    ];
    
                                    $rolAsignado = $nuevoUsuario->abm($datosRol);
    
                                    if ($rolAsignado) {
                                        $response["success"] = true;
                                        $response["mensaje"] = "Registro exitoso. Será redirigido al login.";
                                        $response["redirect"] = "../login/login.php";
                                    } else {
                                        $response["mensaje"] = "No se pudo asignar el rol, intente nuevamente.";
                                    }
                                } else {
                                    $response["mensaje"] = "Usuario no disponible. Intente nuevamente.";
                                }
                            } else {
                                $response["mensaje"] = "Error al registrar usuario.";
                            }
                        }
                    }
                }
            }
            
        } else {
            $response["mensaje"] = "Error. Verifique los datos.";
        }
        return $response;
    }
    
    public function actualizarDatosUsuario($datos) {
        $response = [
            "success" => false,
            "message" => ""
        ];
    
        $usuarioActual = $this->getUsuario();
        if (!$usuarioActual) {
            $response["message"] = "Usuario no encontrado en la sesión.";
        } else {
            $email = $datos['email'] ?? null;
            $password = $datos['password'] ?? null;
            $repetirPassword = $datos['repetirPassword'] ?? null;
            if (empty($email) || empty($password) || empty($repetirPassword)) {
                $response["message"] = "Faltan datos requeridos.";
            } elseif ($password !== $repetirPassword) { //verifica si coinciden las contraseñas
                $response["message"] = "Las contraseñas no coinciden.";
            } else {
                $usuarioObj = new Usuario();
                $usuarioObj->setIdUsuario($usuarioActual->getIdUsuario());
    
                if (!$usuarioObj->buscar()) {
                    $response["message"] = "Usuario no encontrado en la base de datos.";
                } else {
                    $usuarioObj->setUsMail($email);
                    $usuarioObj->setUsPass($password);
    
                    if ($usuarioObj->modificar()) {
                        $response["success"] = true;
                        $response["message"] = "Datos actualizados con éxito.";
                    } else {
                        $response["message"] = "Error al actualizar: " . $usuarioObj->getMensajeOperacion();
                    }
                }
            }
        }
    
        return $response;
    }
    
    public function procesarRol($rolSeleccionado) {
        $response = [
            "success" => false,
            "message" => "",
            "redirect" => null,
        ];
         $roles = $this->getRol();
        $rolValido = false;
        foreach ($roles as $rol) {
            if ($rol->getIdRol() == $rolSeleccionado) {
                $rolValido = true;
                break;
            }
        }
        if ($rolValido) {
            $this->setRol($rolSeleccionado); 
            $response = [
                "success" => true,
                "redirect" => match ($rolSeleccionado) {
                    1 => "../home/home.php",
                    2 => "../administracion/admin.php",
                    3 => "../deposito/depo.php",
                    default => null,
                },
                "message" => "Rol seleccionado correctamente.",
            ];
        } else {
            $response["message"] = "Rol inválido seleccionado.";
        }
        return $response;
    }
}
    

