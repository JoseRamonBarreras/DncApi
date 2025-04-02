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

        #lienzo{margin-top: 140px; margin-bottom: 130px;}
        #header { position: fixed; }
        #footer { position: absolute; left: 0px; bottom: -20px; right: 0px; height: 150px; }
/*        #footer { content: counter(page, upper-roman); }*/
        /*.pagina:before{content: page}*/
        .page:before {
            content: counter(page);
        }
    </style>

    <title>{{$data['documento']->titulo}}</title>
  </head>
  <body id="lienzo">
   

  


   
    @foreach ($data['componentes'] as $componente)
    <div style="padding-left: 20mm; padding-right: 20mm;">
      <p style="color: #60abe4;"><strong>{{$componente->nombre_seccion}}</strong></p>
          {!! $componente->contenido !!}
    </div>
    @endforeach 
    
      
  </body>
</html>