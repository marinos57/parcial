import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('#formularioUsuarios');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

const datatable = new Datatable('#tablaUsuarios', {
    language: lenguaje,
    data: null,
    columns: [
        { title: 'NO', data: null },
        { title: 'NOMBRE', data: 'usu_nombre' },
        { title: 'APELLIDO', data: 'usu_apellido' },
        { title: 'NOMBRE DE USUARIO', data: 'usu_usuario' },
        { title: 'ROL', data: 'usu_rol' },
        { title: 'ESTADO', data: 'usu_situacion' },
        { 
            title: 'CONTRASEÑA', 
            data: 'usu_id',
            render: (data, type, row) => `
                <button class="btn btn-info" data-id='${data}' data-accion='cambiar-contrasena'>Cambiar Contraseña</button>
            `
        },
        {
            title: 'ASIGNAR ROL',
            data: 'usu_id',
            render: (data, type, row) => `
                <button class="btn btn-primary" data-id='${data}' data-accion='asignar-rol'>Asignar Rol</button>
            `
        },
        {
            title: 'ESTADO',
            data: 'usu_id',
            render: (data, type, row) => `
                ${row.usu_situacion === 0 ? 'Pendiente' : 'Activo'}
            `
        },
        {
            title: 'ACCIONES',
            data: 'usu_id',
            render: (data, type, row) => `
                <button class="btn btn-warning" data-id='${data}' data-accion='modificar'>Modificar</button>
                <button class="btn btn-success" data-id='${data}' data-accion='activar-usuario'>Activar Usuario</button>
                <button class="btn btn-danger" data-id='${data}' data-accion='desactivar-usuario'>Desactivar Usuario</button>
            `
        }
    ]
});

// Funciones para cada acción








const cambiarContrasena = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
 
    try {
        //funcion para cambiar
        const url = `/datatable/API/registros/cambiarContrasena`;
        const config = {
            method: 'POST'
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                });
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
    } catch (error) {
        console.log(error);
    }
};

const asignarRol = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
   
    try {
        //funcion para asignar rol
        const url = `/datatable/API/registros/asignarRol/`;
        const config = {
            method: 'POST'
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                });
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
    } catch (error) {
        console.log(error);
    }
};

const activarUsuario = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
  
    try {
        // función del controlador para activar usuario
        const url = `/datatable/API/registros/activar/`;
        const config = {
            method: 'POST'
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                });
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
    } catch (error) {
        console.log(error);
    }
};

const desactivarUsuario = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    
    try {
        //  función del controlador para desactivar usuario
        const url = `/datatable/API/registros/desactivar`;
        const config = {
            method: 'POST'
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                });
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
    } catch (error) {
        console.log(error);
    }
};

// Eventos

datatable.on('click', '.btn-info[data-accion="cambiar-contrasena"]', cambiarContrasena);
datatable.on('click', '.btn-primary[data-accion="asignar-rol"]', asignarRol);
datatable.on('click', '.btn-success[data-accion="activar-usuario"]', activarUsuario);
datatable.on('click', '.btn-danger[data-accion="desactivar-usuario"]', desactivarUsuario);
