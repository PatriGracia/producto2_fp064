<h1>Personas</h1>
<a href="{{route('personas.create')}}">Crear persona</a>
<ul>
    @foreach ($personas as $persona)
       <!--  <li> {//{$persona->Nombre}}</li> -->
       <li>
            <a href="{{route('personas.show', $persona->Id_persona)}}">{{$persona->Nombre}}</a>
       </li>
    @endforeach
</ul>