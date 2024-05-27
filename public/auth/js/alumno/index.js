var $dataTableAlumno, $dataTable;
const $dni_apellido = $("#dni_apellido")
const $table = $("#tableAlumno")

function consultarAlumno(){
    $('#btn_mostrar').attr('mostrar', '')
    $dataTableAlumno.ajax.reload();
}

function clickExcelAlumno(){
    $('.dt-buttons .buttons-excel').click()
}

function mostrarTodo(){
    $('#btn_mostrar').attr('mostrar', 'mostrar')
    $dataTableAlumno.ajax.reload();
}

$(function() {
    $dataTableAlumno = $table.DataTable({
        stripeClasses: [ "odd-row", "even-row" ],
        lengthChange: !0,
        lengthMenu: [ [10, 20, 50, 100, 200, -1 ], [ 10, 20, 50, 100, 200, "Todo" ] ],
        info: !1,
        ajax: {
            url: "/auth/alumno/list_all",
            data: function(s){
                if($dni_apellido.val() != ""){ s.dni_apellido = $dni_apellido.val(); }
                if($('#btn_mostrar').attr('mostrar') != ''){s.mostrar = $('#btn_mostrar').attr('mostrar'); }
            }
            /* dataSrc : function ( res ) { 
                return res.data;
            } */
        },
        columns: [ {
            title: "N°",
            data: null,
            className: "text-center",
            render: function(data, type, row, meta){
                return meta.row + 1;
            }
        }, {
            title: "Año R",
            data: "created_at",
            render: function(data) {
                return null != data ? moment(data).format("YYYY") : "-";
            }
        }, 
        {
            title: "Mes R",
            data: "created_at",
            render: function(data) {
                return null != data ? moment(data).format("MM") : "-";
            },
            className: "d-none"
        },{
            title: "Dia R",
            data: "created_at",
            render: function(data) {
                return null != data ? moment(data).format("DD") : "-";
            },
            className: "d-none"
        },
        {
            title: "DNI",
            data: "dni"
        }, {
            title: "Apellidos",
            data: "apellidos",
            className: "text-left"
        }, {
            title: "Nombres",
            data: "nombres",
            className: "text-left"
        }, {
            title: "Teléfono",
            data: "telefono"
        }, 
        // {
        //     title: "E-mail",
        //     data: "email"
        // }, 
        {
            title: "Grado Académico",
            data: "egresado",
            render: function(data) {
                return data == TIPOS_ALUMNOS.ALUMNO ? "ESTUDIANTE" : data == TIPOS_ALUMNOS.EGRESADO ? "EGRESADO" : data == TIPOS_ALUMNOS.TITULADO ? "TITULADO" : "-";
            }
        }, {
            title: "Carrera",
            data: "areas.nombre",
            render: function(data) {
                return data || "-";
            }
        }, 
        // {
        //     title: "Ciudad",
        //     data: "provincias.nombre",
        //     render: function(data) {
        //         return data || "-";
        //     }
        // },
         {
            title: "Distrito de Residencia",
            data: "distritos.nombre",
            render: function(data) {
                return data || "-";
            }
        }, {
            title: "Información",
            data: null,
            render: function(data) {
                /* console.log("contando: ",data) */
                if( data.perfil_profesional == null || data.perfil_profesional == '' || data.area_id == null || data.area_id == '' || data.provincia_id == null || data.provincia_id == '' || data.distrito_id == null || data.distrito_id == '' || data.dni == null || data.dni == "" || data.telefono == null || data.telefono == "" || data.email == null || data.email == "" || data.fecha_nacimiento == null || data.fecha_nacimiento == "" || data.educaciones.length <1){ /**|| data.hoja_de_vida === null || data.hoja_de_vida === ""**/ 
                    //return "<img src='/auth/image/icon/warning.png' width='25px' title='Falta completar información'>";               
                    return "<p class='badge bg-danger p-5 m-0'>Falta</p>";             
                }else{
                    return "<p class='badge bg-success p-5 m-0'>Lleno</p>";
                }
            }
        },
        {
            title: "",
            data: null,
            render: function(data) {
                if(data.aprobado == ESTADOS.CANCELADO){
                    estado = '<a class="dropdown-item btn-approved" href="#"><i class="fa fa-check"></i> Activar</a>';
                }else if(data.aprobado == ESTADOS.APROBADO){
                    estado = '<a class="dropdown-item btn-cancel" href="#"><i class="fa fa-ban"></i> Bloquear</a>';
                }
                return `<div class="dropup">
                    <a class="" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        </svg>
                    </a>
                    <div class="dropdown-menu p-0">
                    ${estado}
                    <a class="dropdown-item" target='_blank' href='/auth/alumno/print_cv_pdf/${data.id}'><i class='fa fa-address-card'></i> Ver CV</a>
                    <a class="dropdown-item btn-delete" href="#"><i class='fa fa-trash'></i> Eliminar</a>
                    </div>
                </div>`;
            }
        }
            // , {
            //     title: "Aprobado",
            //     data: "aprobado",
            //     render: function(data) {
            //         return data || "0";
            //     }
            // }
        ],
        "rowCallback": function (row, data, index) {
            if(data.aprobado == ESTADOS.CANCELADO){
                $("td", row).css({
                    "background-color": "#f87171",
                    "color": "#fff"
                });
            }
        }   
    });
    $table.on("click", ".btn-cancel", function() {
        const id = $dataTableAlumno.row($(this).parents("tr")).data().id, formData = new FormData();
        formData.append("_token", $("input[name=_token]").val()), formData.append("id", id), 
        formData.append("update_id", ESTADOS.CANCELADO), confirmAjax("/auth/alumno/update", formData, "POST", null, null, function() {
            $dataTableAlumno.ajax.reload(null, !1);
        });
    }), $table.on("click", ".btn-approved", function() {
        const id = $dataTableAlumno.row($(this).parents("tr")).data().id, formData = new FormData();
        formData.append("_token", $("input[name=_token]").val()), formData.append("id", id), 
        formData.append("update_id", ESTADOS.APROBADO), confirmAjax("/auth/alumno/update", formData, "POST", null, null, function() {
            $dataTableAlumno.ajax.reload(null, !1);
        });
    }), $table.on("click", ".btn-delete", function() {
        const id = $dataTableAlumno.row($(this).parents("tr")).data().id, formData = new FormData();
        formData.append("_token", $("input[name=_token]").val()), formData.append("id", id), 
        confirmAjax("/auth/alumno/delete", formData, "POST", null, null, function() {
            $dataTableAlumno.ajax.reload(null, !1);
        });
    });
});
