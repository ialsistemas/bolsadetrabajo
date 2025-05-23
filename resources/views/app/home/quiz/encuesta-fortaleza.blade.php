<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST DE FORTALEZAS PERSONALES – Arzobispo Loayza</title>
    <link rel="stylesheet" href="{{ asset('app/css/home/encuesta-two.css') }}">
    <meta name="description" content="Completa este formulario para conocer más sobre tus fortalezas y afinidades personales. Una iniciativa del Instituto Arzobispo Loayza para apoyarte en tu futuro profesional.">
    <meta name="keywords" content="Instituto Arzobispo Loayza, orientación vocacional, perfil personal, fortalezas, potencial, autoconocimiento, desarrollo profesional">
    <meta name="author" content="Instituto Arzobispo Loayza">
    <link rel="icon" type="image/png" href="{{ asset('app/img/logo_ial.png') }}">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="txt-center">TEST DE FORTALEZAS PERSONALES</h1>
            <p id="description" class="description">Identifica tus fortalezas en el ámbito laboral y reconoce aquello que te hace único. Comparte tus resultados y capta la atención de empresas que buscan talentos como el tuyo.</p>
        </header>
        <form id="survey-form" action="{{ route('alumno.store-test-fortalezas-personales') }}" method="POST">
            @csrf
            @if ($errors->has('error_general'))
                <div class="alert-error">
                    {{ $errors->first('error_general') }}
                </div>
            @endif
            <div class="form-group">
                <p>1. Expresa palabras de aliento para aliviar el estado de tristeza en los demás.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaUno" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaUno" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaUno" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>2. Cambias tu timbre de voz cuando estas enojado(a).</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDos" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDos" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDos" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>3. Constantemente propones nuevas ideas al grupo para alcanzar las metas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTres" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTres" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTres" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>4. Dejas de hacer otras cosas cuando vas a escuchar a los demas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaCuatro" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaCuatro" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaCuatro" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>5. Siente que los musculos de la cara se le ponen rigidos cuando tienen miedo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaCinco" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaCinco" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaCinco" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>6. Guarda discrecion ante los secretos profesionales.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaSeis" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaSeis" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaSeis" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>7. Contiene la ira frente a las situaciones dificiles.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaSiete" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaSiete" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaSiete" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>8. Responde con rapidez ante una oportunidad que se te presenta.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaOcho" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaOcho" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaOcho" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>9. Con solo observar el rostro de una persona percibe la angustia.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaNueve" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaNueve" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaNueve" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>10. En alguna oportunidad cuando a estado enojado(a) a lanzado objetos.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDiez" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDiez" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDiez" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>11. Con solo escuchar el timbre de voz percibe la angustia en los demas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaOnce" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaOnce" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaOnce" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>12. Escuchas con atencion las nuevas ideas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDoce" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDoce" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaSeis" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>13. Haces las cosas mejor cada dia por alcanzar la excelencia laboral y/o educativa.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTrece" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTrece" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTrece" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>14. Te detienes a ayudar a alguien cuando tiene problemas aunque tenga obligaciones pendientes.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaCatorce" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaCatorce" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaCatorce" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>15. Porpones ideas claras frente a situaciones nuevas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaQuince" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaQuince" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaQuince" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>16. Escucha con seriedad las confidencias personales.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDieciseis" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDieciseis" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDieciseis" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>17. Hablas con firmeza para resolver los desacuerdos que se presentan en el grupo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDiecisiete" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDiecisiete" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDiecisiete" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>18. Conviertes en desafio todas las actividades que realizas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDieciocho" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDieciocho" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDieciocho" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>19. Te adaptas con facilidad a nuevas situaciones.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaDiecinueve" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaDiecinueve" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaDiecinueve" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>20. Guarda discrecion ante las confidencias personales.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeinte" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeinte" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeinte" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>21. Mantienes tu timbre de voz firmepara resolver los desacuerdos que se presentan en el grupo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintiuno" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintiuno" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintiuno" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>22. Eleva la voz cuando se enfrenta a problemas dificiles.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintidos" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintidos" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintidos" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>23. Siente que los musculos de sus miembros inferiores se le ponen rigidos cuando tienen miedo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintitres" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintitres" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintitres" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>24. Te detienes a ayudar a alguien cuando tiene problemas aunque tenga obligaciones pendientes.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeinticuatro" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeinticuatro" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeinticuatro" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>25. Asume con calma si tiene alguna responsabilidad en las acciones.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeinticinco" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeinticinco" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeinticinco" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>26. Te dedicas semanalmente en hacer obras beneficas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintiseis" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintiseis" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintiseis" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>27. Eres persistente para conseguir objetos.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintisiete" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintisiete" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintisiete" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>28. Te disgusta ver sufrir a los demas.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintiocho" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintiocho" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintiocho" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>29. Siente que los musculos de sus miembros superiores se le ponen rigidos cuando tienen miedo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaVeintinueve" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaVeintinueve" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaVeintinueve" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>30. Todo lo que te rodea te estimula para seguir progresando.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreinta" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreinta" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreinta" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>31. Guardaas seriedad antes los secretos profesionales.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreintiuno" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreintiuno" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreintiuno" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>32. En alguna oportunidad cuando a estado enajado(a) agredio fisicamente a otra persona.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreintidos" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreintidos" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreintidos" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>33. Frunces el seño cuando estas enojado (a).</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreintitres" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreintitres" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreintitres" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>34. Influyes en la conducta de otra persona mediante el uso de mensajes.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreinticuatro" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreinticuatro" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreinticuatro" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p>35. Te suda las palmas de las manos cuando tienes miedo.</p>
                <div class="radio-group">
                    <label>
                        <input name="preguntaTreinticinco" value="1" type="radio" class="input-radio"> Nunca
                    </label>
                    <label>
                        <input name="preguntaTreinticinco" value="2" type="radio" class="input-radio"> A veces
                    </label>
                    <label>
                        <input name="preguntaTreinticinco" value="3" type="radio" class="input-radio"> Siempre
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submit" class="submit-button">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</body>
</html>