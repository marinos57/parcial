<h2 class="text-center mb-4 text-primary">Registro de usuario</h2>
<div class="row justify-content-center">
    <form class="col-lg-4 border rounded p-3" action="/ruta-de-tu-script-de-registro" method="POST">
        <div class="row mb-3">
            <div class="col">
                <label for="usu_nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="usu_nombre" name="usu_nombre" required>
            </div>
            <div class="col">
                <label for="usu_apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="usu_apellido" name="usu_apellido" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="usu_usuario" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="usu_usuario" name="usu_usuario" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="usu_password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="usu_password" name="usu_password" required>
            </div>
        </div>
        <div class="d-grid">
            <button class="btn btn-primary" type="submit" id="btnGuardar">Registrarse</button>
        </div>
    </form>
    <div class="mt-3">
        <p class="mb-0 text-center">¿Ya tiene una cuenta?<a href="/datatable/login" class="text-primary fw-bold ms-2">Iniciar sesión</a></p>
    </div>
    <script src="<?= asset('./build/js/registro/index.js') ?>"></script>
</div>

