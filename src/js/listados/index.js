import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

let contador = 1
const datatable = new Datatable('#tablaUsuarios', {
    language: lenguaje,
    data: null,
    columns: [
        { title: 'NO', render : () => contador++},

        { title: 'NOMBRE', 
        data: 'usu_nombre' },

        { title: 'APELLIDO', 
        data: 'usu_apellido' },

        { title: 'NOMBRE DE USUARIO', 
        data: 'usu_usuario' },
        // { title: 'ROL', 
        // data: 'usu_rol' },
        { title: 'ESTADO', 
        data: 'usu_situacion' },
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
        const url = `/parcial/API/registros/cambiarContrasena`;
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

const asignaRol = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
   
    try {
        //funcion para asigna rol
        const url = `/parcial/API/registros/asignaRol/`;
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
        const url = `/parcial/API/registros/activarUsuario/`;
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
        const url = `/parcial/API/registros/desactivarUsuario`;
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



const buscar = async () => {
    let usu_nombre = formulario.usu_nombre.value;
    let usu_apellido = formulario.usu_apellido.value;
    let usu_usuario = formulario.usu_usuario.value;

    const url = `/datatable/API/listados/buscar?usu_nombre=${usu_nombre}&usu_apellido=${usu_apellido}&usu_usuario=${usu_usuario}`;
    
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.text();

        console.log(data);
        datatable.clear().draw()
        if(data){
            contador = 1;
            datatable.rows.add(data).draw();
            
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}

buscar();


// Eventos

datatable.on('click', '.btn-info[data-accion="cambiar-contrasena"]', cambiarContrasena);
datatable.on('click', '.btn-primary[data-accion="asignar-rol"]', asignaRol);
datatable.on('click', '.btn-success[data-accion="activar-usuario"]', activarUsuario);
datatable.on('click', '.btn-danger[data-accion="desactivar-usuario"]', desactivarUsuario);
