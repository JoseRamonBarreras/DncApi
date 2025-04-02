<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <style type="text/css">
        /*@page {
            margin: 0;
         
        }*/
        * { padding: 0; margin: 0; }
           
        body{
            font-family: Tahoma,sans-serif;   
            /*padding:10mm;*/   
        }
        p, ol, li{
          font-size: 11pt;
          padding-bottom: 5pt;
          line-height: 15pt;
        }
        ul{
          margin-left: 15px;
        }
        img{
          width: 100%;
        }
        table.users-table {width: 100%;}
        table.users-table thead td p { font-size: 9pt; padding: 5px; text-align: center; }
        table.users-table tbody td p { font-size: 9pt; padding: 5px; text-align: center; }

        #lienzo{margin-top: 170px; margin-bottom: 130px;}
        #header { position: fixed; }
        #footer { position: absolute; left: 0px; bottom: -20px; right: 0px; height: 150px; }
/*        #footer { content: counter(page, upper-roman); }*/
        /*.pagina:before{content: page}*/
        .page:before {
            content: counter(page);
        }
    </style>

    <title>{{$documento->titulo}}</title>
  </head>
  <body id="lienzo">
    <table id="header" style="width: 100%; background: #F5F5F5; margin-bottom: 15px; padding-top: 5mm; padding-bottom: 5mm;">
      <tr>    
        <td style="width: 85%;"> 
          <table style="width: 100%;"> 
            <tr style="width: 100%;"> 
                <td style="width: 100%; text-align: center;">
                  <h5 style="font-size: 10px;">{{$cia->nombre}}</h5>
                  <h5 style="font-size: 25px;">{{$documento->titulo}}</h5>
                  <h5 style="font-size: 10px; margin-top: 20px;">
                    <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
                      <img src="{{ asset('images/clave-icon.png') }}" style="width: 15px; display: inline-block;"> 
                      <span style="display: inline-block; padding-right: 5px">Clave: {{$documento->clave}}</span>
                    </span>
                    <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
                      <img src="{{ asset('images/revision-icon.png') }}" style="width: 15px; display: inline-block;"> 
                      <span style="display: inline-block; padding-right: 5px">
                      Revisión: {{$documento->revision}}
                      </span>
                    </span>
                    <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
                      <img src="{{ asset('images/fecha-icon.png') }}" style="width: 15px; display: inline-block;"> 
                      <span style="display: inline-block; padding-right: 5px">
                        Fecha de revisión: {{ date('Y-m-d', strtotime($version->fecha)) }}
                      </span>
                    </span>
                    <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
                      <img src="{{ asset('images/paginas-icon.png') }}" style="width: 15px; display: inline-block;"> 
                      <span style="display: inline-block; padding-right: 5px; color:#fff;">
                        Página: 0 de 0
                      </span>
                    </span>
                  </h5>
                </td> 
            </tr> 
          </table> 
        </td> 
        <td style="width: 15%;">
          <img src="{{ asset('images') }}/{{$cia->logo}}" width="80">
        </td> 
      </tr>
    </table>

    <table id="footer" style="width: 100%; background: #F5F5F5;">
      <thead>
        <th style="text-align: center;">
          <h5 style="font-size: 10px; margin-top: 20px; margin-bottom: 0px;">
            <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
              <img src="{{ asset('images/elaboro-icon.png') }}" style="width: 15px; display: inline-block;"> 
              <span style="display: inline-block; padding-right: 5px">Elaboró: {{$elaboraName}}</span>
            </span>
          </h5>
          <h5 style="font-size: 8px;">{{$elaboraPuesto}}</h5>
        </th>
        <th style="text-align: center;">
          <h5 style="font-size: 10px; margin-top: 20px; margin-bottom: 0px;">
            <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
              <img src="{{ asset('images/check-icon.png') }}" style="width: 15px; display: inline-block;">
              <span style="display: inline-block; padding-right: 5px">Validó: {{$validaName}}</span>
            </span>
          </h5>
          <h5 style="font-size: 8px;">{{$validaPuesto}}</h5>
        </th>
        <th style="text-align: center;">
          <h5 style="font-size: 10px; margin-top: 20px; margin-bottom: 0px;">
            <span style="background:#fff; padding-top:10px; padding-bottom: 0px; padding-left: 5px; padding-right: 5px; margin-right: 10px; border-radius: 5px;">
              <img src="{{ asset('images/check-icon.png') }}" style="width: 15px; display: inline-block;">
              <span style="display: inline-block; padding-right: 5px">Autorizó: {{$autorizaName}}</span>
            </span>
          </h5>
          <h5 style="font-size: 8px;">{{$autorizaPuesto}}</h5>
        </th>
      </thead>
      <tbody>
        <td style="text-align: center;">
          @if ($elaboraFirma != '')
          <img src="{{ asset('storage/firmas') }}/{{$elaboraFirma}}" style="width: 140px; margin-top: 5px;">
          @endif
        </td>
        <td style="text-align: center;">
          @if ($validaFirma != '')
          <img src="{{ asset('storage/firmas') }}/{{$validaFirma}}" style="width: 140px; margin-top: 5px;">
          @endif
        </td>
        <td style="text-align: center;">
          @if ($autorizaFirma != '')
          <img src="{{ asset('storage/firmas') }}/{{$autorizaFirma}}" style="width: 140px; margin-top: 5px;">
          @endif
        </td>
      </tbody>
    </table>  

   
    @foreach ($componentes as $componente)
    <div style="padding-left: 20mm; padding-right: 20mm;">
      <p style="color: #60abe4;"><strong>{{$componente->nombre_seccion}}</strong></p>
          {!! $componente->contenido !!}
    </div>
    @endforeach 
    
      
  </body>
</html>