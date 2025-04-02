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

    <title>Reporte Refrigeradores: Asignados VS Sin Asignar</title>
  </head>
  <body>
  	<table style="width: 100%; margin-bottom: 20px;">
  		<tr>
  			<td style="width: 100%; text-align: center;">
	    		<h5 style="margin-bottom: 5pt;">Reporte Refrigeradores: Asignados VS Sin Asignar</h5>
          <h5 style="margin-bottom: 5pt;">Del {{$datos->FechaInicio}} al {{$datos->FechaFinal}}</h5>
  			</td>
  		</tr>
  	</table>
    <table style="width: 100%;">
      <tr>
        <td style="width: 100%; text-align: center;">
          <h5 style="margin-bottom: 5pt;">ASIGNADOS {{$datos->NumeroDeAsignados}}</h5>
        </td>
      </tr>
    </table>
  	<table style="margin-bottom: 20px;">
  		<thead>
          <tr>
              <th>Folio</th>
              <th>Clave</th>
              <th>Numero</th>
              <th>Serie</th>
              <th>Modelo</th>
              <th>Sucursal</th>
              <th>Ciudad</th>
              <th>Entregado</th>
              <th>FechaEntregaAsignado</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($datos->Asignados as $refrigerador)
        <tr style="font-weight: bold;">
          <td>{{$refrigerador->Folio}}</td>
          <td>{{$refrigerador->Clave}}</td>
          <td>{{$refrigerador->Numero}}</td>
          <td>{{$refrigerador->Serie}}</td>
          <td>{{$refrigerador->Modelo}}</td>
          <td>{{$refrigerador->Sucursal}} {{$refrigerador->NombreSucursal}}</td>
          <td>{{$refrigerador->Ciudad}}</td>
          <td>
            @if ($refrigerador->Entregado == 1)
                Entregado
            @else
                No Entregado
            @endif
          </td>
          <td>{{$refrigerador->FechaAsignacion}}</td>
        </tr>
        @endforeach 
      </tbody>
  	</table>

    <table style="width: 100%;">
      <tr>
        <td style="width: 100%; text-align: center;">
          <h5 style="margin-bottom: 5pt;">SIN ASIGNAR {{$datos->NumeroDeSinAsignar}}</h5>
        </td>
      </tr>
    </table>
    <table>
      <thead>
          <tr>
              <th>Clave</th>
              <th>Numero</th>
              <th>Serie</th>
              <th>Modelo</th>
              <th>Descripcion</th>
              <th>Ciudad</th>
              <th>FechaAdquisicion</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($datos->SinAsignar as $refrigerador)
        <tr style="font-weight: bold;">
          <td>{{$refrigerador->Clave}}</td>
          <td>{{$refrigerador->Numero}}</td>
          <td>{{$refrigerador->Serie}}</td>
          <td>{{$refrigerador->Modelo}}</td>
          <td>{{$refrigerador->Descripcion}}</td>
          <td>{{$refrigerador->Ciudad}}</td>
          <td>{{$refrigerador->FechaAdquisicion}}</td>
        </tr>
        @endforeach 
      </tbody>
    </table>


  </body>
</html>