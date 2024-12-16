<style>
    .card:hover {
        border: 1px solid #2a527a8b !important;
        /* box-shadow: 0px 0px 33px 2px #2a527a8b inset; */
    }

    .badge {
        display: inline-block;
        padding: 3px 10px !important;
        margin-left: 5px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        border-radius: 20px;
        text-align: center;
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
    }

    .urgent {
        background-color: #128c7e;
        /* Rojo */
    }

    .destacado {
        background-color: orange;
        /* Amarillo */
    }
</style>
<div class="row">
    @foreach ($avisos as $q)
        <div class="col-md-6" style="display:{{ $q->periodo_vigencia < date('Y-m-d') ? 'none' : 'block' }};">
            {{-- {{ $q->empresas->link }} <br> --}}
            {{-- <div class="card" data-empresa="{{ $q->empresas != null ? $q->empresas->link : "-" }}" data-info="{{ $q->link }}"> --}}
            <div class="card" data-empresa="{{ $q->empresas != null ? $q->empresas->id : '-' }}"
                data-info="{{ $q->id }}">
                <div class="row">
                    <div class="badge urgent">
                        <small><i class="fa fa-map-marker" aria-hidden="true"></i>
                            {{ $q->distritos != null ? $q->distritos->nombre : '' }}</small>
                    </div>
                    <div class="badge destacado">
                        @if (count($carrera) > 0)
                            @foreach ($carrera as $value)
                                <small>{{ $q->solicita_carrera == $value->id ? $value->nombre : ' ' }}</small>
                            @endforeach
                        @endif
                    </div>

                    {{-- <div class="col-md-6 not-padding text-right"><a>{{ $q->empresas != null ? $q->empresas->nombre_comercial : "-" }}</a></div> --}}
                    <div class="col-md-12 not-padding">
                        <p>{{ strtoupper($q->titulo) }}</p>
                    </div>
                    <div class="col-md-12 not-padding" style="font-family: 'Arial', sans-serif;">
                        <a>{{ $q->empresas != null ? $q->empresas->nombre_comercial : '-' }}</a>
                    </div>


                    <div class="col-md-12 not-padding"
                        style="font-family: 'Arial', sans-serif; margin-top:20px;text-align:right;color: #adadad;">
                        <small>Públicado el
                            {{ \BolsaTrabajo\App::formatDateStringSpanish($q->created_at) }}</small>
                    </div>


                </div>
            </div>
        </div>
    @endforeach
</div>
