<?php

App::setLocale('es');

Route::get('/', 'App\HomeController@index')->name('index');
Route::get('/loginEmpresa', 'App\HomeController@loginEmpresa')->name('loginEmpresa');
//Route::get('/actualizar', 'App\HomeController@actualizar')->name('actualizar');
Route::get('/filtro_distritos/{id}', 'App\HomeController@filtro_distritos')->name('filtro_distritos');
Route::get('/offline_alumno/{id}', 'App\LoginAlumnoController@offline');

Route::get('/buscar_reniec/{data}', 'App\LoginEmpresaController@consultar_reniec')->name('buscar_reniec');
Route::get('/buscar_sunat/{data}', 'App\LoginEmpresaController@consultar_sunat')->name('buscar_sunat');

Route::get('/resultado-psicologa-beta', 'App\HomeController@resultadoPsicologaBeta')->name('resultado-psicologa-beta');

Route::group(['middleware' => 'auth:alumnos'], function () {
    Route::group(['prefix' => 'alumno'], function () {

        Route::get('/avisos', 'App\AvisoController@avisos')->name('alumno.avisos');
        Route::get('/{empresa}/informacion', 'App\AvisoController@empresa_informacion')->name('alumno.empresa_informacion');
        Route::get('/{empresa}/aviso/{slug}', 'App\AvisoController@informacion')->name('alumno.informacion');
        Route::post('/aviso/postular', 'App\AvisoController@postular')->name('alumno.postular');
        Route::post('/progreso', 'App\AvisoController@progresoCV')->name('alumno.progreso');
        Route::get('/capacitaciones/{id}', 'App\AvisoController@capacitaciones')->name('alumno.capacitaciones');
        Route::get('/certificado/{id}', 'App\AvisoController@certificado')->name('alumno.certificado');
        Route::get('/pendiente/{id}', 'App\AvisoController@pendiente')->name('alumno.pendiente');
        Route::post('/upload-program-requirement', 'App\AvisoController@uploadProgramRequirement')->name('alumno.uploadProgramRequirement');

        //Feria
        Route::get('/feria-alumno/{id}', 'App\AvisoController@feriaEmpresaAlumno')->name('alumno.feria-alumno');
        Route::get('/asesorias-express/{id}', 'App\AvisoController@asesoriasExpressAlumno')->name('alumno.asesorias-express');
        Route::get('/detalle-asesora-express/{id}', 'App\AvisoController@detalleAsesoraExpress')->name('alumno.detalle-asesora-express');
        Route::get('/ecenario-feria-aviso-alumno-empresa/{id}', 'App\AvisoController@ecenarioAvisoAlumnoEmpresa')->name('alumno.ecenario-feria-aviso-alumno-empresa');
        Route::get('/feria-aviso-alumno-empresa/{id}', 'App\AvisoController@feriaAvisoAlumnoEmpresa')->name('alumno.feria-aviso-alumno-empresa');
        Route::post('/detalle-feria-aviso', 'App\AvisoController@detalleFeriaAviso')->name('alumno.detalle-feria-aviso');
        Route::post('/postularme-feria-aviso', 'App\AvisoController@postularme')->name('alumno.postularme-feria-aviso');
        Route::post('/alumno-sacar-cita', 'App\AvisoController@alumnoSacarCita')->name('alumno.alumno-sacar-cita');
        Route::post('/sotre-alumno-sacar-cita', 'App\AvisoController@storeAlumnoSacarCita')->name('alumno.store-alumno-sacar-cita');
        //Route::group(['middleware' => 'alumno'], function () {});

        //test
        Route::get('/test-inteligencias-multiples', 'App\AvisoController@testInteligenciasMultiples')->name('alumno.test-inteligencias-multiples');
        Route::post('/store-test-inteligencias-multiples', 'App\AvisoController@storeTestInteligenciasMultiples')->name('alumno.store-test-inteligencias-multiples');
        Route::get('/resultado-inteligencias-multiples', 'App\AvisoController@resultadoInteligenciasMultiples')->name('alumno.resultado-inteligencias-multiples');
        Route::post('/store-active-inteligencias-multiples', 'App\AvisoController@storeActiveInteligenciasMultiples')->name('alumno.store-active-inteligencias-multiples');
        Route::get('/test-fortalezas-personales', 'App\AvisoController@testFortalezasPersonales')->name('alumno.test-fortalezas-personales');
        Route::post('/store-test-fortalezas-personales', 'App\AvisoController@storeTestFortalezasPersonales')->name('alumno.store-test-fortalezas-personales');
        Route::get('/resultado-fortalezas-personales', 'App\AvisoController@resultadoFortalezasPersonales')->name('alumno.resultado-fortalezas-personales');
        Route::post('/store-active-fortalezas-personales', 'App\AvisoController@storeActiveFortalezasPersonales')->name('alumno.store-active-fortaleza');
        //

        Route::get('/perfil', 'App\AlumnoController@index')->name('alumno.perfil');
        Route::post('/perfil', 'App\AlumnoController@store')->name('alumno.store');

        Route::get('/perfil/validacion', 'App\AlumnoController@perfil_validacion')->name('alumno.perfil_validacion');

        Route::get('/perfil/educaciones', 'App\AlumnoController@educaciones')->name('alumno.perfil.educaciones');
        Route::get('/perfil/partialViewEducacion/{id}', 'App\AlumnoController@educacion')->name('alumno.perfil.educacion');
        Route::post('/perfil/educacion', 'App\AlumnoController@educacion_store')->name('alumno.perfil.educacion_store');
        Route::post('/perfil/educacion/delete', 'App\AlumnoController@educacion_delete')->name('alumno.perfil.educacion_delete');

        Route::get('/perfil/experiencias', 'App\AlumnoController@experiencias')->name('alumno.perfil.experiencias');
        Route::get('/perfil/partialViewExperienciaLaboral/{id}', 'App\AlumnoController@experiencia_laboral')->name('alumno.perfil.experiencia_laboral');
        Route::post('/perfil/experiencia', 'App\AlumnoController@experiencia_store')->name('alumno.perfil.experiencia_store');
        Route::post('/perfil/experiencia/delete', 'App\AlumnoController@experiencia_delete')->name('alumno.perfil.experiencia_delete');

        Route::get('/perfil/referencias', 'App\AlumnoController@referencias')->name('alumno.perfil.referencias');
        Route::get('/perfil/partialViewReferenciaLaboral/{id}', 'App\AlumnoController@referencia_laboral')->name('alumno.perfil.referencia_laboral');
        Route::post('/perfil/referencia', 'App\AlumnoController@referencia_store')->name('alumno.perfil.referencia_store');
        Route::post('/perfil/referencia/delete', 'App\AlumnoController@referencia_delete')->name('alumno.perfil.referencia_delete');

        Route::get('/perfil/habilidades', 'App\AlumnoController@habilidades')->name('alumno.perfil.habilidades');
        Route::get('/perfil/partialViewHabilidad/{id}', 'App\AlumnoController@habilidad')->name('alumno.perfil.habilidad');
        Route::get('/perfil/partialViewHabilidadProfesional/{id}', 'App\AlumnoController@habilidad_profesional')->name('alumno.perfil.habilidad_profesional');
        Route::post('/perfil/habilidad', 'App\AlumnoController@habilidad_store')->name('alumno.perfil.habilidad_store');

        Route::get('/perfil/experiencia-laboral/{id}', 'App\AlumnoController@experienciaLaboral')->name('alumno.perfil.experiencia-laboral');
        Route::get('/perfil/new-experiencia-laboral', 'App\AlumnoController@newExperienciaLaboral')->name('alumno.perfil.new-experiencia-laboral');
    });
});

/* -------------- MIS POSTULACIONES ----------------*/
Route::get('/postulaciones', 'App\PostulacionesController@index')->name('alumno.postulaciones');
/* ------------------------------------ */

Route::get('/{empresa}/aviso/{slug}/postulantes/{alumno}', 'App\AvisoController@donwloadCValumno')->name('empresa.cv_postulante');

Route::get('/alumno/pdf', 'App\AlumnoController@donwloadCValumno');

Route::group(['middleware' => 'auth:empresasw'], function () {
    Route::group(['prefix' => 'empresa'], function () {

        Route::get('/perfil', 'App\EmpresaController@index')->name('empresa.perfil');
        Route::post('/perfil', 'App\EmpresaController@store')->name('empresa.store');
        /* ACA SON LAS RUTAS DE CAMBIO LINK POR ID */

        /* Este es para el nuevo requerimiento de republicar - Hecho por sebastian */
        /* JALAR DATOS AL NUEVO REPUBLICAR */
        Route::get('/avisos/partialView2/{id}', 'App\EmpresaController@partialView2')->name('empresa.partialView2');
        /* GUARDAR */
        Route::post('/avisos/republicar', 'App\EmpresaController@republicar')->name('empresa.republicar');
        /* Route::get('/avisos/listarr_aviso2', 'App\EmpresaController@listarr_aviso2')->name('empresa.listarr_aviso2'); */


        Route::get('/avisos', 'App\EmpresaController@listar_aviso')->name('empresa.avisos');
        Route::get('/{empresa}/aviso/{slug}', 'App\AvisoController@informacion')->name('empresa.informacion');
        Route::get('/{empresa}/aviso/{slug}/postulantes', 'App\AvisoController@postulantes')->name('empresa.postulantes');
        Route::get('/{empresa}/aviso/{slug}/postulantes/{alumno}', 'App\AvisoController@postulante_informacion')->name('empresa.postulante_informacion');
        Route::get('/avisos/registrar', 'App\EmpresaController@registrar_aviso')->name('empresa.registrar_aviso');
        Route::get('/avisos/listar', 'App\EmpresaController@listar_aviso')->name('empresa.listar_aviso');
        Route::get('/avisos/listar_json', 'App\EmpresaController@listar_aviso_json')->name('empresa.listar_aviso_json');
        Route::get('/avisos/partialView/{id}', 'App\EmpresaController@partialView_aviso')->name('empresa.partialView_aviso');
        Route::get('/avisos/partialViewPostulante/{id}', 'App\EmpresaController@partialViewAvisoPostulantes')->name('empresa.aviso.postulantes');
        Route::get('/avisos/list_all_postulantes', 'App\EmpresaController@list_avisoPostulantes')->name('empresa.aviso.list_postulantes');

        Route::post('/avisos/storeAviso', 'App\EmpresaController@store_aviso')->name('empresa.store_aviso');
        Route::post('/avisos/updateAviso', 'App\EmpresaController@update_aviso')->name('empresa.update_aviso');
        Route::post('/avisos/alumno/clasificar', 'App\AvisoController@clasificar_aviso')->name('empresa.clasificar_aviso');
        Route::post('/avisos/delete', 'Auth\AvisoController@delete')->name('empresa.aviso.delete');
        Route::get('/app/listar_aviso_json', 'App\EmpresaController@listar_aviso_json')->name('app.listar_aviso_json');

        //Feria
        Route::get('/feria-empresa/{id}', 'App\EmpresaController@feriaEmpresa')->name('empresa.feria-empresa');
        Route::get('/agregar-feria-empresa/{id}', 'App\EmpresaController@agregarFeriaEmpresa')->name('empresa.agregar-feria-empresa');
        Route::post('/store-agregar-feria-empresa', 'App\EmpresaController@storeAgregarFeriaEmpresa')->name('empresa.store-agregar-feria-empresa');
        Route::get('/eliminar-feria-empresa/{id}', 'App\EmpresaController@eliminarFeriaEmpresa')->name('empresa.eliminar-feria-empresa');
        Route::get('/postulante-feria-empresa/{id}', 'App\EmpresaController@postulanteFeriaEmpresa')->name('empresa.postulante-feria-empresa');
        Route::get('/postulante-feria-cv/{id}', 'App\EmpresaController@postulanteFeriaCv')->name('empresa.postulante-feria-cv');
    });
});



Route::post('empresa/login', 'App\LoginEmpresaController@login')->name('empresa.login.post');
Route::post('empresa/logout', 'App\LoginEmpresaController@logout')->name('empresa.logout');

Route::get('empresa/registrar', 'App\HomeController@crear_empresa')->name('empresa.crear_empresa');
Route::post('empresa/registrar', 'App\HomeController@registrar_empresa')->name('empresa.registrar_empresa.post');

Route::post('alumno/login', 'App\LoginAlumnoController@login')->name('alumno.login.post');
Route::post('alumno/logout', 'App\LoginAlumnoController@logout')->name('alumno.logout');


Route::get('alumno/registrar', 'App\HomeController@crear_alumno')->name('alumno.crear_alumno');
Route::post('alumno/registrar', 'App\HomeController@registrar_alumno')->name('alumno.registrar_alumno.post');

/* ADMINISTRADOR */
Route::get('/home/notification', 'Auth\EmpresaController@notification')->name('auth.home.notification');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:web'], function () {
    Route::get('/home', 'Auth\HomeController@index')->name('auth.index');

    Route::group(['prefix' => 'inicio'], function () {
        Route::get('/', 'Auth\InicioController@index')->name('auth.inicio');


        // Route::post('/store', 'Auth\InicioController@store')->name('auth.inicio.store');
        // Route::get('/list_all', 'Auth\InicioController@list')->name('auth.inicio.list');
        // Route::post('/delete', 'Auth\InicioController@delete')->name('auth.inicio.delete');
        /* Route::get('/list_all', 'Auth\AvisoPostulacionController@list')->name('auth.avisoPostulacion.list'); */
    });

    Route::group(['prefix' => 'alumno'], function () {
        Route::get('/', 'Auth\AlumnoController@index')->name('auth.alumno');
        Route::get('/list_all', 'Auth\AlumnoController@list')->name('auth.alumno.list');
        Route::get('/partialView/{id}', 'Auth\AlumnoController@partialView')->name('auth.alumno.create');
        Route::get('/print_cv_pdf/{id}/', 'Auth\AlumnoController@print_cv_pdf')->name('auth.alumno.print_cv_pdf');
        Route::post('/update', 'Auth\AlumnoController@update')->name('auth.alumno.update');
        Route::post('/delete', 'Auth\AlumnoController@delete')->name('auth.alumno.delete');
    });

    Route::group(['prefix' => 'empresa'], function () {
        Route::get('/', 'Auth\EmpresaController@index')->name('auth.empresa');
        Route::get('/list_all', 'Auth\EmpresaController@list')->name('auth.empresa.list');
        Route::get('/partialView/{id}', 'Auth\EmpresaController@partialView')->name('auth.empresa.create');
        Route::post('/update', 'Auth\EmpresaController@update')->name('auth.empresa.update');
        Route::post('/update_data', 'Auth\EmpresaController@updateData')->name('auth.empresa.update_data');
        Route::post('/delete', 'Auth\EmpresaController@delete')->name('auth.empresa.delete');
    });

    Route::group(['prefix' => 'aviso'], function () {
        Route::get('/', 'Auth\AvisoController@index')->name('auth.aviso');
        Route::get('/list_all', 'Auth\AvisoController@list')->name('auth.aviso.list');
        Route::get('/partialViewPostulante/{id}', 'Auth\AvisoController@partialViewPostulantes')->name('auth.aviso.postulantes');

        Route::get('/partialViewEditarEstado/{idalumno}/{idaviso}', 'Auth\AvisoController@partialEditarEstados')->name('auth.aviso.partialEditarEstado');
        Route::post('/updateEstado', 'Auth\AvisoController@updateEstado')->name('auth.aviso.updateEstado');

        Route::get('/partialViewAviso/{id}', 'Auth\AvisoController@partialViewAviso')->name('auth.aviso.postulantes2');

        Route::get('/partialViewEditarAviso/{id}', 'Auth\AvisoController@partialViewEditarAviso')->name('auth.aviso.partialViewEditarAviso');
        Route::post('/update', 'Auth\AvisoController@update')->name('auth.aviso.update');

        Route::post('/updateAvisoEstado', 'Auth\AvisoController@updateEstadoAviso')->name('auth.aviso.updateAvisoEstado');

        Route::get('/ajax_list', 'Auth\AvisoController@partialViewPostulantesEstudiantes')->name('auth.aviso.ajax_list');

        Route::get('/ajax_list2', 'Auth\AvisoController@partialViewPostulantesEstudiantes2')->name('auth.aviso.ajax_list2');

        Route::get('/list_all_postulantes', 'Auth\AvisoController@list_postulantes')->name('auth.aviso.list_postulantes');
        Route::post('/delete', 'Auth\AvisoController@delete')->name('auth.aviso.delete');
    });

    Route::group(['prefix' => 'feria'], function () {
        Route::get('/', 'Auth\FeriaController@index')->name('auth.feria');
        Route::get('/agregar-feria', 'Auth\FeriaController@agregarFeria')->name('auth.agregar-feria');
        Route::post('/store-agregar-feria', 'Auth\FeriaController@storeAgregarFeria')->name('auth.store-agregar-feria');
        Route::get('/ferias/filtrar', "Auth\FeriaController@filtrar")->name('auth.ferias.filtrar');
        Route::get('/ferias/edit/{id}', "Auth\FeriaController@edit")->name('auth.ferias.edit');
        Route::get('/ferias/delete/{id}', "Auth\FeriaController@deleteFeria")->name('auth.ferias.delete');
        Route::post('/store-editar-feria', 'Auth\FeriaController@storeEditarFeria')->name('auth.store-editar-feria');
        Route::get('/listada-empresa/{id}', "Auth\FeriaController@listadaEmpresa")->name('auth.feria.listada-empresa');
        Route::get('/listada-empresa-postulantes/{id}', "Auth\FeriaController@listadaEmpresaPostulantes")->name('auth.feria.listada-empresa-postulantes');
        Route::get('/ver-cv-empresa-postulante/{id}', "Auth\FeriaController@verCvEmpresaPostulante")->name('auth.feria.ver-cv-empresa-postulante');
        Route::get('/lista-citas-asesora', "Auth\FeriaController@listaCitasAsesora")->name('auth.lista-citas-asesora');
        Route::get('/filtrar-citas-asesoras', "Auth\FeriaController@filtrarCitasAsesoras")->name('auth.ferias.filtrar-citas-asesoras');
        Route::get('/citas-asesora/finalizar/{id}', "Auth\FeriaController@finalizarCitasAsesora")->name('auth.ferias.finalizar-citas-asesora');
    });

    Route::group(['prefix' => 'avisoPostulacion'], function () {
        Route::get('/', 'Auth\AvisoPostulacionController@index')->name('auth.avisoPostulacion');
        Route::get('/list_all', 'Auth\AvisoPostulacionController@list')->name('auth.avisoPostulacion.list');
    });

    Route::group(['prefix' => 'anuncio'], function () {
        Route::get('/', 'Auth\AnuncioController@index')->name('auth.anuncio');
        Route::post('/store', 'Auth\AnuncioController@store')->name('auth.anuncio.store');
        Route::get('/list_all', 'Auth\AnuncioController@list')->name('auth.anuncio.list');
        Route::post('/delete', 'Auth\AnuncioController@delete')->name('auth.anuncio.delete');
        /* Route::get('/list_all', 'Auth\AvisoPostulacionController@list')->name('auth.avisoPostulacion.list'); */
    });

    Route::group(['prefix' => 'anuncioempresa'], function () {
        Route::get('/', 'Auth\AnuncioEmpresaController@index')->name('auth.anuncioempresa');
        Route::post('/store', 'Auth\AnuncioEmpresaController@store')->name('auth.anuncioempresa.store');
        Route::get('/list_all', 'Auth\AnuncioEmpresaController@list')->name('auth.anuncioempresa.list');
        Route::post('/delete', 'Auth\AnuncioEmpresaController@delete')->name('auth.anuncioempresa.delete');
        /* Route::get('/list_all', 'Auth\AvisoPostulacionController@list')->name('auth.avisoPostulacion.list'); */
    });

    /* Programa Controladores */
    Route::group(['prefix' => 'programa'], function () {
        Route::get('/', 'Auth\ProgramaController@index')->name('auth.programa');
        Route::get('/empleabilidad', 'Auth\ProgramaController@indexEmpleabilidad')->name('auth.programa-empleabilidad');
        Route::post('/store', 'Auth\ProgramaController@store')->name('auth.programa.store');
        Route::post('/store-empleabilidad', 'Auth\ProgramaController@storeEmpleabilidad')->name('auth.programa.store-empleabilidad');
        Route::get('/list_all', 'Auth\ProgramaController@listAll')->name('auth.programas.listAll');
        Route::get('/list_all_empleabilidad', 'Auth\ProgramaController@listAllEmpleabilidad')->name('auth.programas.empleabilidad-list');
        Route::post('/updateData', 'Auth\ProgramaController@updateData')->name('auth.programa.updateData');
        Route::post('/updateDataEmpleabilidad', 'Auth\ProgramaController@updateDataEmpleabilidad')->name('auth.programa.updateDataEmpleabilidad');
        Route::get('/partialView/{id}', 'Auth\ProgramaController@partialView')->name('auth.programa.create');
        Route::get('/partialViewEmpleabilidad/{id}', 'Auth\ProgramaController@partialViewEmpleabilidad')->name('auth.programa.create-empleabilidad');
        Route::post('/delete', 'Auth\ProgramaController@delete')->name('auth.programas.delete');
        Route::post('/deleteEmpleabilidad', 'Auth\ProgramaController@deleteEmpleabilidad')->name('auth.programas.delete-empleabilidad');
        /* Participantes */
        Route::get('/partialViewParticipantes/{id}', 'Auth\ProgramaController@partialViewParticipantes')->name('auth.programa.partialViewParticipantes');
        Route::get('/partialViewParticipantesEmpleabilidad/{id}', 'Auth\ProgramaController@partialViewParticipantesEmpleabilidad')->name('auth.programa.partialViewParticipantesEmpleabilidad');
        Route::post('/storeParticipantes', 'Auth\ProgramaController@storeParticipantes')->name('auth.programa.storeParticipantes');
        Route::post('/storeParticipantesEmpleabilidad', 'Auth\ProgramaController@storeParticipantesEmpleabilidad')->name('auth.programa.storeParticipantesEmpleabilidad');
        Route::get('/mostrarParticipantes', 'Auth\ProgramaController@mostrarParticipantes')->name('auth.programa.mostrarParticipantes');
        Route::get('/mostrarParticipantesEmpleabilidad', 'Auth\ProgramaController@mostrarParticipantesEmpleabilidad')->name('auth.programa.mostrarParticipantesEmpleabilidad');
        Route::post('/deletepar', 'Auth\ProgramaController@deletepar')->name('auth.programas.deletepar');
        Route::post('/deleteparEmpleabilidad', 'Auth\ProgramaController@deleteparEmpleabilidad')->name('auth.programas.deleteparEmpleabilidad');
        Route::get('/partialViewpar/{id}', 'Auth\ProgramaController@partialViewpar')->name('auth.programa.create');
        Route::get('/partialViewparEmpleabilidad/{id}', 'Auth\ProgramaController@partialViewparEmpleabilidad')->name('auth.programa.create-empleabilidad');
        Route::post('/updateParticipanteInscrito', 'Auth\ProgramaController@updateParticipanteInscrito')->name('auth.programa.updateParticipanteInscrito');
        Route::post('/updateParticipanteInscritoEmpleabilidad', 'Auth\ProgramaController@updateParticipanteInscritoEmpleabilidad')->name('auth.programa.updateParticipanteInscritoEmpleabilidad');
        Route::get('/generarCertificadoEmpleabilidad/{id}', 'Auth\ProgramaController@generarCertificadoEmpleabilidad')->name('auth.programa.generarCertificadoEmpleabilidad');
        Route::post('/validarEmpleabilidad', 'Auth\ProgramaController@validarEmpleabilidad')->name('auth.programa.validarEmpleabilidad');
    });

    Route::post('store_estudiante_aviso', 'Auth\AvisoController@store_estudiante_aviso')->name('auth.aviso.store_estudiante_aviso');

    Route::post('store_seguimiento', 'Auth\AvisoController@store_seguimiento')->name('auth.aviso.store_seguimiento');


    Route::group(['prefix' => 'area'], function () {
        Route::get('/', 'Auth\AreaController@index')->name('auth.area');
        Route::get('/list_all', 'Auth\AreaController@list_all')->name('auth.area.list_all');
        Route::get('/partialView/{id}', 'Auth\AreaController@partialView')->name('auth.area.create');
        Route::post('/store', 'Auth\AreaController@store')->name('auth.area.store');
        Route::post('/delete', 'Auth\AreaController@delete')->name('auth.area.delete');
    });

    // SECTION USUARIO

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'Auth\UsuariosController@index')->name('auth.usuarios');
        Route::get('/list_all', 'Auth\UsuariosController@list_all')->name('auth.usuarios.list_all');
        Route::post('/store', 'Auth\UsuariosController@store')->name('auth.usuarios.store');
        Route::post('/delete', 'Auth\UsuariosController@delete')->name('auth.usuarios.delete');
        Route::get('/partialView/{id}', 'Auth\UsuariosController@partialView')->name('auth.usuarios.create');
    });

    // END SECTION USUARIO

    Route::group(['prefix' => 'cargo'], function () {
        Route::get('/', 'Auth\CargoController@index')->name('auth.cargo');
        Route::get('/list_all', 'Auth\CargoController@list_all')->name('auth.cargo.list_all');
        Route::get('/partialView/{id}', 'Auth\CargoController@partialView')->name('auth.cargo.create');
        Route::post('/store', 'Auth\CargoController@store')->name('auth.cargo.store');
        Route::post('/delete', 'Auth\CargoController@delete')->name('auth.cargo.delete');
    });

    Route::group(['prefix' => 'horario'], function () {
        Route::get('/', 'Auth\HorarioController@index')->name('auth.horario');
        Route::get('/list_all', 'Auth\HorarioController@list_all')->name('auth.horario.list_all');
        Route::get('/partialView/{id}', 'Auth\HorarioController@partialView')->name('auth.horario.create');
        Route::post('/store', 'Auth\HorarioController@store')->name('auth.horario.store');
        Route::post('/delete', 'Auth\HorarioController@delete')->name('auth.horario.delete');
    });

    Route::group(['prefix' => 'modalidad'], function () {
        Route::get('/', 'Auth\ModalidadController@index')->name('auth.modalidad');
        Route::get('/list_all', 'Auth\ModalidadController@list_all')->name('auth.modalidad.list_all');
        Route::get('/partialView/{id}', 'Auth\ModalidadController@partialView')->name('auth.modalidad.create');
        Route::post('/store', 'Auth\ModalidadController@store')->name('auth.modalidad.store');
        Route::post('/delete', 'Auth\ModalidadController@delete')->name('auth.modalidad.delete');
    });

    Route::group(['prefix' => 'habilidad'], function () {
        Route::get('/', 'Auth\HabilidadController@index')->name('auth.habilidad');
        Route::get('/profesional', 'Auth\HabilidadController@index_profesional')->name('auth.habilidad_profesional');
        Route::get('/list_all', 'Auth\HabilidadController@list_all')->name('auth.habilidad.list_all');
        Route::get('/partialView/{id}', 'Auth\HabilidadController@partialView')->name('auth.habilidad.create');
        Route::post('/store', 'Auth\HabilidadController@store')->name('auth.habilidad.store');
        Route::post('/delete', 'Auth\HabilidadController@delete')->name('auth.habilidad.delete');
    });

    // SECTION ALUMNO SANCIONADO
    Route::group(['prefix' => 'alumnosancionado'], function () {
        Route::get('/', 'Auth\AlumnoSancionadoController@index')->name('auth.alumnosancionado');
        Route::get('/list_all', 'Auth\AlumnoSancionadoController@list_all')->name('auth.usuarios.list_all');
        Route::post('/store', 'Auth\AlumnoSancionadoController@store')->name('auth.alumnosancionado.store');
        Route::post('/update', 'Auth\AlumnoSancionadoController@update')->name('auth.alumnosancionado.update');
        Route::post('/delete', 'Auth\AlumnoSancionadoController@delete')->name('auth.alumnosancionado.delete');
        Route::get('/partialViewSancionado/{id}', 'Auth\AlumnoSancionadoController@partialViewSancionado')->name('auth.alumnosancionado.create');
    });

    Route::group(['prefix' => 'principal'], function () {
        Route::get('/', 'Auth\PrincipalController@index')->name('auth.principal');
    });

    Route::group(['prefix' => 'error'], function () {
        Route::get('/', 'Auth\ErrorController@index')->name('auth.error');
    });

    Route::group(['prefix' => 'eventos'], function () {
        Route::get('/', 'Auth\EventosController@index')->name('auth.eventos');
        Route::get('/list_all', 'Auth\EventosController@list_all')->name('auth.eventos.list_all');
        Route::get('/partialView/{id}', 'Auth\EventosController@partialView')->name('auth.eventos.create');
        Route::post('/store', 'Auth\EventosController@store')->name('auth.eventos.store');
        /* Falta update */
        Route::post('/update', 'Auth\EventosController@update')->name('auth.eventos.update');
        Route::post('/delete', 'Auth\EventosController@delete')->name('auth.eventos.delete');
        /* Asistentes de Eventos */
        Route::get('/partialViewAsistentes/{id}', 'Auth\EventosController@partialViewAsistentes')->name('auth.eventos.create');
        Route::get('/mostrarParticipantesAsistentes', 'Auth\EventosController@mostrarParticipantesAsistentes')->name('auth.eventos.mostrarParticipantesAsistentes');
        Route::get('/partialViewEditAsistente/{id}', 'Auth\EventosController@partialViewEditAsistente')->name('auth.eventos.create');
        Route::post('/deleteAsistentes', 'Auth\EventosController@deleteAsistentes')->name('auth.eventos.deleteAsistentes');
        Route::get('/listA', 'Auth\EventosController@listA')->name('auth.eventos.listA');
    });

    Route::group(['prefix' => 'eventosasistencia'], function () {
        Route::get('/', 'Auth\EventosAsistenciaController@index')->name('auth.eventosasistencia');
        Route::post('/store', 'Auth\EventosAsistenciaController@store')->name('auth.eventosasistencia.store');
        Route::post('/update', 'Auth\EventosAsistenciaController@update')->name('auth.eventosasistencia.update');
    });

    Route::group(['prefix' => 'certificados'], function () {
        Route::get('/', 'Auth\CertificadosController@index')->name('auth.certificados');
        Route::get('/list_all', 'Auth\CertificadosController@list_all')->name('auth.certificados.list_all');
        Route::get('/partialView/{id}', 'Auth\CertificadosController@partialView')->name('auth.certificados.create');
        Route::get('/mostrarParticipantes', 'Auth\CertificadosController@mostrarParticipantes')->name('auth.certificados.mostrarParticipantes');
        Route::get('/partialViewCertificado/{id}', 'Auth\CertificadosController@partialViewCertificado')->name('auth.certificados.create');
        Route::post('/deleteAlumno', 'Auth\CertificadosController@deleteAlumno')->name('auth.certificados.deleteAlumno');
        Route::post('/store', 'Auth\CertificadosController@store')->name('auth.certificados.store');


        /* Route::post('/update', 'Auth\CertificadosController@update')->name('auth.certificados.update'); */
    });

    Route::group(['prefix' => 'configuracion'], function () {
        Route::get('/', 'Auth\ConfiguracionController@index')->name('auth.configuracion');
        Route::get('/list_all', 'Auth\ConfiguracionController@list_all')->name('auth.configuracion.list_all');
        Route::post('/update', 'Auth\ConfiguracionController@update')->name('auth.configuracion.update');
    });
});



Route::group(['prefix' => 'auth'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

    Route::get('/changePassword/partialView', 'Auth\LoginController@partialView_change_password')->name('auth.login.partialView_change_password');
    Route::post('/changePassword', 'Auth\LoginController@change_password')->name('auth.login.change_password');

    /*Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');*/
});

Route::get('publicar_oferta', 'Auth\LoginController@view_publicar_oferta');
