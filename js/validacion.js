'use strict';

/**
 * NovaShop — Fase 2: validacion.js
 * ---------------------------------------------------------------
 * Hace funcionar de verdad el formulario maquetado en la Fase 1
 * (contacto.html): valida los campos, muestra errores visibles y
 * responde en la misma página sin recargarla.
 */

const REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const REGEX_TELEFONO = /^[\d()+\-\s]{7,20}$/; // dígitos, espacios, ( ) + -
const LONGITUD_MINIMA_MENSAJE = 10;

/**
 * ¿El campo tiene algo escrito (sin contar espacios)?
 * @param {string} valor
 * @returns {boolean}
 */
function esCampoObligatorioValido(valor) {
  return valor.trim().length > 0;
}

/**
 * Valida el formato de un correo electrónico.
 * @param {string} valor
 * @returns {boolean}
 */
function esEmailValido(valor) {
  return REGEX_EMAIL.test(valor.trim());
}

/**
 * Valida el formato de un número de teléfono.
 * @param {string} valor
 * @returns {boolean}
 */
function esTelefonoValido(valor) {
  return REGEX_TELEFONO.test(valor.trim());
}

/**
 * Revisa todos los campos del formulario de contacto y arma un
 * objeto con los errores encontrados (uno por campo, si aplica).
 * @param {Object} datos - { nombre, email, telefono, producto, mensaje }
 * @returns {Object} { valido: boolean, errores: Object }
 */
function validarFormularioContacto(datos) {
  const errores = {};

  if (!esCampoObligatorioValido(datos.nombre)) {
    errores.nombre = 'Escribe tu nombre completo.';
  }

  if (!esCampoObligatorioValido(datos.email)) {
    errores.email = 'El correo es obligatorio.';
  } else if (!esEmailValido(datos.email)) {
    errores.email = 'Ese correo no parece válido, revisa que tenga @ y un dominio.';
  }

  if (!esCampoObligatorioValido(datos.telefono)) {
    errores.telefono = 'El teléfono es obligatorio.';
  } else if (!esTelefonoValido(datos.telefono)) {
    errores.telefono = 'Escribe un teléfono válido (solo números, espacios, + y -).';
  }

  if (!esCampoObligatorioValido(datos.producto)) {
    errores.producto = 'Selecciona un producto de interés.';
  }

  if (!esCampoObligatorioValido(datos.mensaje)) {
    errores.mensaje = 'Cuéntanos qué necesitas.';
  } else if (datos.mensaje.trim().length < LONGITUD_MINIMA_MENSAJE) {
    errores.mensaje = 'El mensaje debe tener al menos ' + LONGITUD_MINIMA_MENSAJE + ' caracteres.';
  }

  return {
    valido: Object.keys(errores).length === 0,
    errores: errores,
  };
}

/**
 * Muestra (o limpia) el mensaje de error debajo de un campo específico
 * y marca visualmente el campo como inválido.
 * @param {string} idCampo
 * @param {string} mensaje - vacío ('') para limpiar el error
 */
function mostrarError(idCampo, mensaje) {
  const spanError = document.getElementById('error-' + idCampo);
  const campo = document.getElementById(idCampo);
  if (!spanError) return;

  spanError.textContent = mensaje || '';
  if (campo) {
    campo.classList.toggle('campo-invalido', Boolean(mensaje));
  }
}

/**
 * Limpia los mensajes de error de una lista de campos.
 * @param {Array<string>} idsCampos
 */
function limpiarErrores(idsCampos) {
  idsCampos.forEach(function (id) {
    mostrarError(id, '');
  });
}

// --- Conexión con el DOM: solo corre en páginas que tengan el formulario ---
document.addEventListener('DOMContentLoaded', function () {
  const formulario = document.getElementById('form-contacto');
  if (!formulario) return;

  const idsCampos = ['nombre', 'email', 'telefono', 'producto', 'mensaje'];
  const mensajeExito = document.getElementById('form-mensaje-exito');

  formulario.addEventListener('submit', function (evento) {
    evento.preventDefault(); // evita que la página se recargue

    const datos = {
      nombre: formulario.nombre.value,
      email: formulario.email.value,
      telefono: formulario.telefono.value,
      producto: formulario.producto.value,
      mensaje: formulario.mensaje.value,
    };

    limpiarErrores(idsCampos);
    const resultado = validarFormularioContacto(datos);

    if (!resultado.valido) {
      idsCampos.forEach(function (id) {
        if (resultado.errores[id]) {
          mostrarError(id, resultado.errores[id]);
        }
      });
      if (mensajeExito) {
        mensajeExito.textContent = '';
        mensajeExito.className = '';
      }
      return;
    }

    // Fase 3: validación del cliente OK -> ahora sí se manda de verdad al
    // servidor (api/contacto_guardar.php), que valida otra vez y guarda
    // el mensaje en la base de datos. Seguimos sin recargar la página.
    const boton = formulario.querySelector('button[type="submit"]');
    if (boton) boton.disabled = true;

    fetch('api/contacto_guardar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datos),
    })
      .then(function (respuesta) { return respuesta.json(); })
      .then(function (resultadoServidor) {
        if (!resultadoServidor.ok) {
          if (resultadoServidor.errores) {
            idsCampos.forEach(function (id) {
              if (resultadoServidor.errores[id]) {
                mostrarError(id, resultadoServidor.errores[id]);
              }
            });
          }
          if (mensajeExito) {
            mensajeExito.textContent = resultadoServidor.error || 'No se pudo enviar el mensaje. Intenta de nuevo.';
            mensajeExito.className = 'mensaje-error-login';
          }
          return;
        }

        if (mensajeExito) {
          mensajeExito.textContent = resultadoServidor.mensaje;
          mensajeExito.className = 'mensaje-exito';
        }
        formulario.reset();
      })
      .catch(function () {
        if (mensajeExito) {
          mensajeExito.textContent = 'No se pudo conectar con el servidor. Intenta de nuevo.';
          mensajeExito.className = 'mensaje-error-login';
        }
      })
      .finally(function () {
        if (boton) boton.disabled = false;
      });
  });
});
