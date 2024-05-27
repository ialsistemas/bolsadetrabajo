<div id="modalMantenimientoExperienciaLaboral" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" id="registroExperienciaLaboral" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Experiencia != null ? "Modificar" : "Registrar" }} Experiencia</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Experiencia != null ? $Experiencia->id : 0 }}">
                    <div class="form-group row">
                        <div class="col-md-12 mt-2">
                            <input type="text" name="empresa" id="empresa" value="{{ $Experiencia != null ? $Experiencia->empresa : "" }}" class="form-input" placeholder="Empresa / Negocio / Atención particular" required>
                            <span data-valmsg-for="empresa"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <input type="text" name="puesto" id="puesto" value="{{ $Experiencia != null ? $Experiencia->puesto : "" }}" class="form-input" placeholder="Puesto" required>
                            <span data-valmsg-for="puesto"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <select name="sector" class="form-input" id="sector" required>
                                <option value="{{ $Experiencia != null ? $Experiencia->sector : "" }}" selected hidden>{{ $Experiencia != null ? $Experiencia->sector : "-- Tipo de Sector --" }}</option>
                                <option value="Agricultura; plantaciones, otros sectores rurales ">Agricultura; plantaciones, otros sectores rurales </option>
                                <option value="Alimentación; bebidas; tabaco">Alimentación; bebidas; tabaco</option>
                                <option value="Comercio">Comercio</option>
                                <option value="Construcción">Construcción</option>
                                <option value="Educación">Educación</option>
                                <option value="Fabricación de material de transporte">Fabricación de material de transporte</option>
                                <option value="Función pública">Función pública</option>
                                <option value="Hotelería, restauración, turismo">Hotelería, restauración, turismo</option>
                                <option value="Industrias químicas">Industrias químicas</option>
                                <option value="Ingenieria mecánica y eléctria">Ingenieria mecánica y eléctria</option>
                                <option value="Medios de comunicación; cultura; gráficos">Medios de comunicación; cultura; gráficos</option>
                                <option value="Minería (carbón, otra minería)">Minería (carbón, otra minería)</option>
                                <option value="Petroleo y producción de gas; refinación de petroleo">Petroleo y producción de gas; refinación de petroleo</option>
                                <option value="Producción de metales básicos">Producción de metales básicos</option>
                                <option value="Servicios de correos y de telecomunicaciones"> Servicios de correos y de telecomunicaciones</option>
                                <option value="Servicios de salud">Servicios de salud</option>
                                <option value="Servicios financieros; servicios profesionales">Servicios financieros; servicios profesionales</option>
                                <option value="Servicios públicos (agua; gas; electricidad)">Servicios públicos (agua; gas; electricidad)</option>
                                <option value="Silvicultura; madera; celulosa; papel">Silvicultura; madera; celulosa; papel</option>
                                <option value="Textiles; vestido; cuero; calzado">Textiles; vestido; cuero; calzado</option>
                                <option value="Transporte (inluyendo aviación civil; ferrocarriles; transporte por carretera)">Transporte (inluyendo aviación civil; ferrocarriles; transportepor carretera)</option>
                                <option value="Transporte marítimo; puertos; pesca; transporte interior">Transporte marítimo; puertos; pesca; transporte interior</option>
                            </select>
                        </div>  
                        <div class="col-md-6 mt-2">
                            <select name="estado" class="form-input" id="estado" required>
                                <option value="{{ $Experiencia != null ? $Experiencia->estado : "" }}" selected hidden>{{ $Experiencia != null ? $Experiencia->estado : "Estado" }}</option>
                                <option value="Hasta la actualidad">Hasta la actualidad</option>
                                <option value="Culminado">Culminado</option>
                            </select>
                        </div>                      
                        <div class="col-md-6 mt-2">
                            <input type="text" id="inicio_laburo" name="inicio_laburo" class="form-input" value="{{ $Experiencia != null ? $Experiencia->inicio_laburo : "" }}" placeholder="Inicio del Laburo" onfocus="(this.type = 'month')" onblur="(this.type='text')" >                          
                        </div>
                        <div class="col-md-6 mt-2">
                            <input type="text" id="fin_laburo" name="fin_laburo" class="form-input" value="{{ $Experiencia != null ? $Experiencia->fin_laburo : "" }}" placeholder="Fin del Laburo" onfocus="(this.type = 'month')" onblur="(this.type='text')" >
                        </div>
                    </div>
                    {{-- textarea oulto no funciona xd --}}
                    <div class="form-group row" hidden>
                        <div class="col-md-12 mt-2">
                            <textarea name="descrip" class="form-input" placeholder="Funciones Desempeñadas" cols="30" rows="3">{{ $Experiencia != null ? $Experiencia->descripcion : "" }}</textarea>
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label style="margin-bottom: -16px;" for="">FUNCIONES DESEMPEÑADAS</label>
                            <input type="text" class="form-input" name="descrip" id="descripcion" placeholder="Funciones Desempeñadas" value="{{ $Experiencia != null ? $Experiencia->descripcion : "" }}" required>
                            {{-- <textarea name="descrip" id="descripcion" class="form-input" placeholder="Funciones Desempeñadas" cols="30" rows="3" required>{{ $Experiencia != null ? $Experiencia->descripcion : "" }}</textarea> --}}
                        </div>
                    </div>

                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-bold btn-pure btn-primary">{{ $Experiencia != null ? "Modificar" : "Registrar" }} Experiencia</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('auth/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
    /* CKEDITOR.replace( 'descripcion' ); */
</script>

<script type="text/javascript" src="{{ asset('app/js/alumno/_experienciaLaboral.js') }}"></script>
