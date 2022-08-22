<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
            
/*======================
    404 page
=======================*/


.page_404{ padding:40px 0; background:#fff; font-family: 'Arvo', serif;
}

.page_404  img{ width:100%;}


.four_zero_four_bg{
 
 background: url('/frontend/images/dribbble_1.gif') no-repeat; 
    height: 400px;
    background-position: center;
 }
 
 
 .four_zero_four_bg h1{
 font-size:80px;
 }
 
  .four_zero_four_bg h3{
       font-size:80px;
       }
       
       .link_404{      
  color: #fff!important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;}
  .contant_box_404{ margin-top:-50px;}

  .center {
text-align: center;
}

    </style>
</head>

<body>

        <!-- Content Header (Page header) -->

        <!-- Main content -->
            <section class="page_404 center">
                <div class="container">
                    <div class="row"> 
                        <div class="col-sm-12">
                            <div class="col-sm-10 col-sm-offset-1  text-center">
                                <div class="four_zero_four_bg">
                                    <h1 class="text-center ">404</h1>      
                                </div>
                                
                                <div class="contant_box_404">
                                    <h3 class="h2">
                                        Apparement vous êtes perdus !
                                    </h3>
                                    <p>La page que vous cherchez n'est pas disponible...</p>
                                    <a href="/home" class="link_404">Retourner à l'Acceuil de GEDES</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <!-- /.content -->

</body>

</html>