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
            padding:20mm;
         
        }
        * { padding: 0; margin: 0; }
           
        body{
            font-family: Tahoma,sans-serif;   
            padding:20mm;   
            
        }
        p{
          font-size: 6pt;
          padding-bottom: 10pt;
          line-height: 15pt;
        }
        #footer { position: fixed; left: 0px; bottom: -110px; right: 0px; height: 150px; }
       #footer .page:after { content: counter(page, upper-roman); }
    </style>

    <title>Comodato</title>
  </head>
  <body>
    <img src="{{ asset('storage/firmas') }}/{{$firma}}" style="width: 200px;">
  </body>
</html>