<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <style type="text/css">
        @page {
            margin: 0;
            padding:10mm;
         
        }
        * { padding: 0; margin: 0; }
           
        body{
            font-family: Tahoma,sans-serif;   
            padding:10mm;   
            
        }
        h5{
          font-size: 8pt;
        }
        p{
        	font-size: 6pt;
        	padding-bottom: 10pt;
        	line-height: 15pt;
        }
        tr{
          font-size: 6pt;
        }
        th{
          text-align: left;
          padding-right: 12px;
        }
        td{
          text-align: left;
          padding-right: 12px;
        }
        #footer { position: fixed; left: 0px; bottom: -110px; right: 0px; height: 150px; }
       #footer .page:after { content: counter(page, upper-roman); }
    </style>

    <title>Reporte Incidencias</title>
  </head>
  <body>
  	<table style="width: 100%;">
  		<tr>
  			<td style="width: 100%; text-align: center;">
	    		<h5 style="margin-bottom: 5pt;">REPORTE DE INCIDENCIAS</h5>
          <h5 style="margin-bottom: 5pt;">Del {{$datos->FechaInicio}} al {{$datos->FechaFinal}}</h5>
  			</td>
  		</tr>
  	</table>
  	<table>
  		<thead>
          <tr>
              <th style="width: 10%;">Incidencia</th>
              <th>Folio</th>
              <th style="width: 15%;">Serie</th>
              <th style="width: 10%;">Clave</th>
              <th style="width: 10%;">Numero</th>
              <th>Modelo</th>
              <th style="width: 20%;">Sucursal</th>
              <th>Tipo</th>
              <th>Status</th>
              <th>Fecha</th>
          </tr>
      </thead>
      <tbody>
        <tr>
          <td>ABIERTO</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
          <td></td><td></td><td></td>
        </tr>
        @foreach ($datos->Abierto as $incidencia)
        <tr style="font-weight: bold;">
          <td>{{$incidencia->Incidencia}}</td>
          <td>{{$incidencia->Folio}}</td>
          <td>{{$incidencia->Serie}}</td>
          <td>{{$incidencia->Clave}}</td>
          <td>{{$incidencia->Numero}}</td>
          <td>{{$incidencia->Modelo}}</td>
          <td>{{$incidencia->Sucursal}} {{$incidencia->NombreSucursal}}</td>
          <td>{{$incidencia->TipoNombre}}</td>
          <td>{{$incidencia->Status}}</td>
          <td>{{$incidencia->created_at}}</td>
        </tr>
            @foreach ($incidencia->MetaStatus as $meta)
            <tr>
              <td></td>
              <td>ID:</td>
              <td>{{$meta->Status}}</td>
              <td>Comentarios:</td>
              <td>{{$meta->Comentarios}}</td>
              <td>Usuario:</td>
              <td>{{$meta->UserId}} {{$meta->UserName}}</td>
              <td>Status:</td>
              <td>{{$meta->Nombre}}</td>
              <td>{{$meta->FechaStatus}}</td>
            </tr>
            @endforeach
        @endforeach

        <!-- ------------------- -->

        <tr>
          <td>EN ESPERA</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
          <td></td><td></td><td></td>
        </tr>
        @foreach ($datos->EnEspera as $incidencia)
        <tr style="font-weight: bold;">
          <td>{{$incidencia->Incidencia}}</td>
          <td>{{$incidencia->Folio}}</td>
          <td>{{$incidencia->Serie}}</td>
          <td>{{$incidencia->Clave}}</td>
          <td>{{$incidencia->Numero}}</td>
          <td>{{$incidencia->Modelo}}</td>
          <td>{{$incidencia->Sucursal}} {{$incidencia->NombreSucursal}}</td>
          <td>{{$incidencia->TipoNombre}}</td>
          <td>{{$incidencia->Status}}</td>
          <td>{{$incidencia->created_at}}</td>
        </tr>
            @foreach ($incidencia->MetaStatus as $meta)
            <tr>
              <td></td>
              <td>ID:</td>
              <td>{{$meta->Status}}</td>
              <td>Comentarios:</td>
              <td>{{$meta->Comentarios}}</td>
              <td>Usuario:</td>
              <td>{{$meta->UserId}} {{$meta->UserName}}</td>
              <td>Status:</td>
              <td>{{$meta->Nombre}}</td>
              <td>{{$meta->FechaStatus}}</td>
            </tr>
            @endforeach
        @endforeach

        <!-- --------------------- -->

        <tr>
          <td>RESUELTO</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
          <td></td><td></td><td></td>
        </tr>
        @foreach ($datos->Resuelto as $incidencia)
        <tr style="font-weight: bold;">
          <td>{{$incidencia->Incidencia}}</td>
          <td>{{$incidencia->Folio}}</td>
          <td>{{$incidencia->Serie}}</td>
          <td>{{$incidencia->Clave}}</td>
          <td>{{$incidencia->Numero}}</td>
          <td>{{$incidencia->Modelo}}</td>
          <td>{{$incidencia->Sucursal}} {{$incidencia->NombreSucursal}}</td>
          <td>{{$incidencia->TipoNombre}}</td>
          <td>{{$incidencia->Status}}</td>
          <td>{{$incidencia->created_at}}</td>
        </tr>
            @foreach ($incidencia->MetaStatus as $meta)
            <tr>
              <td></td>
              <td>ID:</td>
              <td>{{$meta->Status}}</td>
              <td>Comentarios:</td>
              <td>{{$meta->Comentarios}}</td>
              <td>Usuario:</td>
              <td>{{$meta->UserId}} {{$meta->UserName}}</td>
              <td>Status:</td>
              <td>{{$meta->Nombre}}</td>
              <td>{{$meta->FechaStatus}}</td>
            </tr>
            @endforeach
        @endforeach

        <!-- ---------------- -->

        <tr>
          <td>CERRADO</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
          <td></td><td></td><td></td>
        </tr>
        @foreach ($datos->Cerrado as $incidencia)
        <tr style="font-weight: bold;">
          <td>{{$incidencia->Incidencia}}</td>
          <td>{{$incidencia->Folio}}</td>
          <td>{{$incidencia->Serie}}</td>
          <td>{{$incidencia->Clave}}</td>
          <td>{{$incidencia->Numero}}</td>
          <td>{{$incidencia->Modelo}}</td>
          <td>{{$incidencia->Sucursal}} {{$incidencia->NombreSucursal}}</td>
          <td>{{$incidencia->TipoNombre}}</td>
          <td>{{$incidencia->Status}}</td>
          <td>{{$incidencia->created_at}}</td>
        </tr>
            @foreach ($incidencia->MetaStatus as $meta)
            <tr>
              <td></td>
              <td>ID:</td>
              <td>{{$meta->Status}}</td>
              <td>Comentarios:</td>
              <td>{{$meta->Comentarios}}</td>
              <td>Usuario:</td>
              <td>{{$meta->UserId}} {{$meta->UserName}}</td>
              <td>Status:</td>
              <td>{{$meta->Nombre}}</td>
              <td>{{$meta->FechaStatus}}</td>
            </tr>
            @endforeach
        @endforeach
      </tbody>
  	</table>

  </body>
</html>