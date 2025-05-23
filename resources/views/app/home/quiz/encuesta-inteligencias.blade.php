<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST  de competencias y habilidades – Arzobispo Loayza</title>
    <link rel="stylesheet" href="{{ asset('app/css/home/encuesta.css') }}">
    <meta name="description" content="Completa este formulario para conocer más sobre tus fortalezas y afinidades personales. Una iniciativa del Instituto Arzobispo Loayza para apoyarte en tu futuro profesional.">
    <meta name="keywords" content="Instituto Arzobispo Loayza, orientación vocacional, perfil personal, fortalezas, potencial, autoconocimiento, desarrollo profesional">
    <meta name="author" content="Instituto Arzobispo Loayza">
    <link rel="icon" type="image/png" href="{{ asset('app/img/logo_ial.png') }}">
</head>
<body>
    <div class="ancho">
    <div class="contenedor-todo">
        <header class="encabezado">
            <h1 id="title">TEST  de competencias y habilidades<br></h1>
            <p id="description">Identifica tus fortalezas en el ámbito laboral y reconoce aquello que te hace único. Comparte tus resultados y capta la atención de empresas que buscan talentos como el tuyo.</p>
        </header>
        <form action="{{ route('alumno.store-test-inteligencias-multiples') }}" method="POST" class="contenedor-formulario" id="survey-form">
            @csrf
            @if ($errors->has('error_general'))
                <div class="alert-error">
                    {{ $errors->first('error_general') }}
                </div>
            @endif
            <!-- Pregunta 1-->
            <div class="componentesFormulario">
                <p>1. Prefiero hacer un mapa que explicarle a alguien como tiene que llegar.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaUna" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaUna" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 2-->
            <div class="componentesFormulario">
                <p>2. Si estoy enojado(a) o contento (a) generalmente sé exactamente por qué.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDos" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDos" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 3-->
            <div class="componentesFormulario">
                <p>3. Sé tocar (o antes sabía tocar) un instrumento musical.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTres" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTres" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 4-->
            <div class="componentesFormulario">
                <p>4. Asocio la música con mis estados de ánimo.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaCuatro" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaCuatro" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 5-->
            <div class="componentesFormulario">
                <p>5. Puedo sumar o multiplicar mentalmente con mucha rapidez.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaCinco" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaCinco" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 6-->
            <div class="componentesFormulario">
                <p>6. Puedo ayudar a un amigo a manejar sus sentimientos porque yo lo pude hacer antes en relación a sentimientos parecidos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaSeis" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaSeis" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 7-->
            <div class="componentesFormulario">
                <p>7. Me gusta trabajar con calculadoras y computadores.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaSiete" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaSiete" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 8-->
            <div class="componentesFormulario">
                <p>8. Aprendo rápido a bailar un ritmo nuevo.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaOcho" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaOcho" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 9-->
            <div class="componentesFormulario">
                <p>9. No me es difícil decir lo que pienso en el curso de una discusión o debate.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaNueve" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaNueve" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 10-->
            <div class="componentesFormulario">
                <p>10. Disfruto de una buena charla, discurso o sermón.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDiez" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDiez" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 11-->
            <div class="componentesFormulario">
                <p>11. Siempre distingo el norte del sur, esté donde esté.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaOnce" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaOnce" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 12-->
            <div class="componentesFormulario">
                <p>12. Me gusta reunir grupos de personas en una fiesta o en un evento especial.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDoce" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDoce" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 13-->
            <div class="componentesFormulario">
                <p>13. La vida me parece vacía sin música.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTrece" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTrece" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 14-->
            <div class="componentesFormulario">
                <p>14. Siempre entiendo los gráficos que vienen en las instrucciones de equipos o instrumentos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaCatorce" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaCatorce" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 15-->
            <div class="componentesFormulario">
                <p>15. Me gusta hacer rompecabezas y entretenerme con juegos electrónicos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaQuince" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaQuince" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 16-->
            <div class="componentesFormulario">
                <p>16. Me fue fácil aprender a andar en bicicleta. ( o patines).</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDieciseis" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDieciseis" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 17-->
            <div class="componentesFormulario">
                <p>17. Me enojo cuando oigo una discusión o una afirmación que parece ilógica.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDiecisiete" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDiecisiete" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 18-->
            <div class="componentesFormulario">
                <p>18. Soy capaz de convencer a otros que sigan mis planes.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDieciocho" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDieciocho" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 19-->
            <div class="componentesFormulario">
                <p>19. Tengo buen sentido de equilibrio y coordinación.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaDiecinueve" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaDiecinueve" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 20-->
            <div class="componentesFormulario">
                <p>20. Con  frecuencia  veo  configuraciones  y  relaciones  entre  números  con  más rapidez y facilidad que otros.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeinte" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeinte" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 21-->
            <div class="componentesFormulario">
                <p>21. Me gusta construir modelos (o hacer esculturas).</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintiuno" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintiuno" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 22-->
            <div class="componentesFormulario">
                <p>22. Tengo agudeza para encontrar el significado de las palabras.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintidos" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintidos" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 23-->
            <div class="componentesFormulario">
                <p>23. Puedo mirar un objeto de una manera y con la misma facilidad volver a verlo.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintitres" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintitres" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 24-->
            <div class="componentesFormulario">
                <p>24. Con frecuencia hago la conexión entre una pieza de música y algún evento de mi vida.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeinticuatro" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeinticuatro" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 25-->
            <div class="componentesFormulario">
                <p>25. Me gusta trabajar con números y figuras.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeinticinco" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeinticinco" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 26-->
            <div class="componentesFormulario">
                <p>26. Me  gusta  sentarme  silenciosamente  y  reflexionar  sobre  mis  sentimientos íntimos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintiseis" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintiseis" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 27-->
            <div class="componentesFormulario">
                <p>27. Con sólo mirar la forma de construcciones y estructuras me siento a gusto.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintisiete" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintisiete" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 28-->
            <div class="componentesFormulario">
                <p>28. Me gusta tararear, silbar y cantar en la ducha o cuando estoy sola.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintiocho" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintiocho" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 29-->
            <div class="componentesFormulario">
                <p>29. Soy bueno(a) para el atletismo.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaVeintinueve" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaVeintinueve" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 30-->
            <div class="componentesFormulario">
                <p>30. Me gusta escribir cartas detalladas a mis amigos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreinta" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreinta" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 31-->
            <div class="componentesFormulario">
                <p>31. Generalmente me doy cuenta de la expresión que tengo en la cara</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreintaiuno" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreintaiuno" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 32-->
            <div class="componentesFormulario">
                <p>32. Me doy cuenta de las expresiones en la cara de otras personas.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreintaidos" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreintaidos" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 33-->
            <div class="componentesFormulario">
                <p>33. Me  mantengo  "en  contacto"  con  mis  estados  de  ánimo.  No  me  cuesta identificarlos.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreintaitres" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreintaitres" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 34-->
            <div class="componentesFormulario">
                <p>34. Me doy cuenta de los estados de ánimo de otros.</p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreintaicuatro" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreintaicuatro" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!-- Pregunta 35-->
            <div class="componentesFormulario">
                <p>35. Me doy cuenta bastante bien de lo que otros piensan de mí. </p>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="preguntaTreintaicinco" value="1" title="Verdadero" class="input-radio">Verdadero
                    </label>
                    <label>
                        <input type="radio" name="preguntaTreintaicinco" value="0" title="Falso" class="input-radio">Falso
                    </label>
                </div>
            </div>
            <!--Campo boton-->
            <div class="componentesFormulario">
                <button 
                type="submit" 
                id="submit"
                class="input-boton"
                title="bt">
                Enviar
                </button>
            </div>
        </form>
    </div>
    </div>
</body>
</html>