import Swal from "sweetalert2";
import { validarFormulario, Toast } from "../funciones";

const formulario = document.querySelector('form');
const btnGuardar = document.getElementById('btnGuardar');

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['usu_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('usu_id');
    const url = '/parcial/API/registros/guardar';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }

        Swal.fire({
            icon,
            title: mensaje,
            showConfirmButton: false,
            timer: 1500
        });

    } catch (error) {
        console.log(error);
    }
};

btnGuardar.addEventListener('click', guardar);
