// VERIFICACION DE DATOS DEL USUARIO
$(document).ready(function() {

    $.validator.addMethod("notEqualTo", function(value, element, param) {
        return this.optional(element) || value !== $(param).val();
    }, "Tiene que tener un valor diferente...");

    $.validator.addMethod("lettersAndNumbers", function(value, element) {
        return this.optional(element) || (/^[a-zA-Z]/.test(value) && /[0-9]/.test(value));
    }, "Debe contener letras y números");

    
    $('#datosUsuario').validate({
        // Mensaje de error por defecto
        message: 'Este valor no es válido',
        
        // Configuración de reglas de validación
        rules: {
            usnombre: {
                required: true, // El nombre es obligatorio
                minlength: 8,   // Longitud mínima de 8 caracteres
                maxlength: 20,  // Longitud máxima de 20 caracteres
                lettersAndNumbers: true,
            },
            uspass: {
                required: true, // La contraseña es obligatoria
                minlength: 8,   // Longitud mínima de 8 caracteres
                lettersAndNumbers: true,
                notEqualTo: "#usnombre" // La contraseña no debe ser igual al nombre de usuario
            },
            uspass2: {
                required: true, // La confirmación de la contraseña es obligatoria
                minlength: 8,   // Longitud mínima de 8 caracteres
                equalTo: "#uspass" // Las contraseñas deben coincidir
            },
            usmail: {
                required: true, // El correo es obligatorio
                email: true // Validación para correo electrónico
            }
        },
        
        // Mensajes personalizados de validación
        messages: {
            usnombre: {
                required: "El nombre es obligatorio",
                minlength: "El nombre debe tener al menos 8 caracteres",
                maxlength: "El nombre no puede superar los 20 caracteres",
                lettersAndNumbers: "El nombre solo puede contener letras, números, puntos y guiones bajos"
            },
            uspass: {
                required: "La contraseña es obligatoria",
                minlength: "La contraseña debe tener al menos 8 caracteres",
                lettersAndNumbers: "La contraseña debe contener al menos una letra y un número",
                notEqualTo: "La contraseña no puede ser igual al nombre de usuario"
            },
            uspass2: {
                required: "La confirmación de la contraseña es obligatoria",
                minlength: "La confirmación de la contraseña debe tener al menos 8 caracteres",
                equalTo: "Las contraseñas deben coincidir"
            },
            usmail: {
                required: "El correo es obligatorio",
                email: "Por favor, ingrese un correo válido"
            }
        },
        
        // Configuración de cómo mostrar los errores
        errorElement: "div", // Los errores se mostrarán en un <div>
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback"); // Se aplica una clase de error
            error.insertAfter(element); // Se inserta el error después del campo
        },
        
        // Resaltar los campos con errores
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid"); // Resaltar el campo con error
        },
        
        // Quitar el resaltado cuando el campo es válido
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid"); // Remover el resaltado de error
        }
    });
});


//DATOS DEL PRODUCTO
$(document).ready(function() {
    $('#datosProducto').validate({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            idproducto: {
                message: 'ID no válido',
                validators: {
                    notEmpty: {
                        message: 'El ID es obligatorio'
                    },
                    regexp: {
                        regexp: /^[A-Z][0-9]+/,
                        message: 'Identificador de tipo y número'
                    }
                }
            },
            pronombre: {
                message: 'Nombre no válido',
                validators: {
                    notEmpty: {
                        message: 'El nombre no es válido'
                    },
                    regexp: {
                        regexp: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
                        message: 'La primer letra en mayúscula. Solo letras.'
                    }
                }
            },
            prodetalle: {
                message: 'Detalle no válido',
                validators: {
                    notEmpty: {
                        message: 'El detalle es obligatorio'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]/,
                        message: 'Detalle no válido'
                    }
                }
            },
            proprecio: {
                message: 'Precio no válido',
                validators: {
                    notEmpty: {
                        message: 'El precio es obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9]/,
                        message: 'Precio no válido'
                    }
                }
            },
            prodescuento: {
                message: 'Descuento no válido',
                validators: {
                    notEmpty: {
                        message: 'El descuento es obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9]/,
                        message: 'Descuento no válido'
                    }
                }
            },
            procantstock: {
                message: 'Cantidad en stock no válida',
                validators: {
                    notEmpty: {
                        message: 'La cantidad en stock es obligatoria'
                    },
                    regexp: {
                        regexp: /^[0-9]/,
                        message: 'Cantidad en stock no válida'
                    }
                }
            }
        }
    });
});

//DATOS DEL MENU
$(document).ready(function() {
    $('#datosMenu').validate({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            menombre: {
                message: 'Nombre no válido',
                validators: {
                    notEmpty: {
                        message: 'El nombre es obligatorio'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]/,
                        message: 'Nombre no válido'
                    }
                }
            },
            medescripcion: {
                message: 'Descripcion no válida',
                validators: {
                    notEmpty: {
                        message: 'La descripción es obligatoria'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]/,
                        message: 'Descripción no válida'
                    }
                }
            }
        }
    });
});

//DATOS DE LA TARJETA
$(document).ready(function() {
    $('#datosTarjeta').validate({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nombreapellido: {
                message: 'Datos no válidos',
                validators: {
                    notEmpty: {
                        message: 'Estos datos son obligatorios'
                    },
                    regexp: {
                        regexp: /^[a-z ,.'-]+$/i,
                        message: 'Datos no válidos'
                    }
                }
            },
            numtarjeta: {
                message: 'Datos no válidos',
                validators: {
                    notEmpty: {
                        message: 'Estos datos son obligatorios'
                    },
                    regexp: {
                        regexp: /[0-9]{16}/,
                        message: 'Datos no válidos'
                    }
                }
            },
            vencimiento: {
                message: 'Datos no válidos',
                validators: {
                    notEmpty: {
                        message: 'Estos datos son obligatorios'
                    }
                    // regexp: {
                    //     regexp:
                    // }
                }
            },
            codigo: {
                message: 'Datos no válidos',
                validators: {
                    notEmpty: {
                        message: 'Estos datos son obligatorios'
                    },
                    regexp: {
                        regexp: /^[0-9]{3}/,
                        message: 'Datos no válidos'
                    }
                }
            }
        }
    });
});