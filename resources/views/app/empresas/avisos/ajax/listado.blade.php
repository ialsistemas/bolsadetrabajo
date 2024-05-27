<div class="row">
    @foreach($avisos as $q)
        <div class="col-md-6">
            <div class="card" data-info="{{ $q->link }}">
                <div class="row">
                    <div class="col-md-4 text-left"><small>Lima, Lima</small></div>
                    <div class="col-md-8 text-right"><a>WebAltoque</a></div>
                    <div class="col-md-12">
                        <p>{{ $q->titulo }}</p>
                    </div>
                    <div class="col-md-4 text-left"><small>Full-time</small></div>
                    <div class="col-md-8 text-right"><small>Públicado el 26 de febrero</small></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
