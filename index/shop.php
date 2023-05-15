<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistema de Inventario | Tienda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="../public/img/apple-touch-icon.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
</head>

<style>
    @media (max-width: 991px) {
        .cabecera {
            top: 0 !important;
        }
    }

    .label {
        display: inline;
        padding: 0.2em 0.6em 0.3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25em;
    }

    .card img {
        width: 100%;
        height: auto;
    }

    @supports(object-fit: cover) {
        .card img {
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
    }

    #noResults {
        display: none;
    }

    .lista-categoria:hover {
        background-color: #e6e6e6;
    }
</style>

<?php include('../config/Conexion.php');
$sql = "SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,u.nombre as usuario,ae.nombre as articulo,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.stock as stock,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen";
$result = $conexion->query($sql);
?>

<?php include('../config/Conexion.php');
$sql = "SELECT * FROM categoria WHERE condicion = 1";
$result3 = $conexion->query($sql);
?>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block position-sticky sticky-top" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:jorgepomar10@gmail.com">jorgepomar10@gmail.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="whatsapp://send?text=¡Hola!, mucho gusto 🤝, me interesa saber más información 🙂.&phone=+51 937 075 845">+51 937 075 845</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow position-sticky sticky-top bg-white cabecera" style="z-index: 5000; top: 40px;">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h2 mt-2 align-self-center" href="index.html">
                San Andrés S.A.C.
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">Artículos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contáctenos</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">
                    <!-- <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2"></i>
                    </a> -->
                    <a class="nav-icon position-relative text-decoration-none" href="shop.php">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1 fs-4"></i>
                    </a>
                    <a class="nav-icon position-relative text-decoration-none" href="../vistas/login.html">
                        <i class="fa fa-fw fa-user text-dark mr-3 fs-4"></i>
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <!-- Close Header -->

    <!-- Modal -->
    <!-- <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div> -->



    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-3 p-3" style="background-color:#f1f1f1; border-radius: 0.50em;">
                <h1 class="h2 pb-4">Categorías</h1>
                <ul class="list-unstyled templatemo-accordion">
                    <?php
                    foreach ($result3 as $row) {
                        $idcategoria = $row['idcategoria'];
                    ?>
                        <li class="pb-3">
                            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                                <?php echo ucwords(strtolower($row['nombre'])) ?>
                                <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                            </a>
                            <ul class="collapse show list-unstyled pl-3">
                                <?php
                                include('../config/Conexion.php');
                                $sql = "SELECT ae.nombre as articulo, ve.idventaexterna as idventaexterna FROM venta_externa ve INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=$idcategoria WHERE ae.idcategoria= c.idcategoria";
                                $result2 = $conexion->query($sql);

                                foreach ($result2 as $row2) {
                                ?>
                                    <li class="lista-categoria"><a class="text-decoration-none categoria" href="shop-single.php?id=<?php echo $row2['idventaexterna'] ?>" style="margin-left: 10px; color: #479e5d;"><strong><?php echo ucwords(strtolower($row2['articulo'])) ?></strong></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12 pb-4">
                        <div class="d-flex">
                            <input type="text" class="form-control w-100" placeholder="Buscar artículo." name="txtBuscar" id="txtBuscar" autocomplete="off" maxlength="60">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    foreach ($result as $row) {
                    ?>
                        <div class="col-md-4 tarjetaGeneral">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="../files/articulos/<?php echo $row['imagen'] ?>" style="height: 280px;">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <?php if($row['stock'] > 0){ ?>
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2" href="shop-single.php?id=<?php echo $row['idventaexterna'] ?>"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a class="h3 text-decoration-none titulo"><strong><?php echo ucwords(strtolower($row['articulo'])) ?></strong></a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-1">
                                        <li>
                                            <span style="font-size: 11px; color: #a6a6a6;">Publicado por: <strong><?php echo $row['usuario'] ?></strong>.</span>
                                        </li>
                                        <li>
                                            <span style="font-size: 11px; color: #a6a6a6;">Fecha: <strong><?php $fecha = $row['fecha'];
                                                                                                            $nuevaFecha = new DateTime($fecha);
                                                                                                            $fechaConvertida = $nuevaFecha->format("Y-m-d");
                                                                                                            echo $fechaConvertida; ?></strong></span>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li>
                                            <?php echo ($row['estado'] == 'Activado') ? '<span class="label" style="background-color: #00a65a !important; font-size: 14px;">Disponible</span>' : '<span class="label" style="background-color: #dd4b39 !important; font-size: 14px;">No disponible</span>' ?>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0" style="font-size: 21px !important">S/. <?php echo $row['precio'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <span id="noResults">No se encontraron resultados.</span>
                </div>
            </div>

        </div>
    </div>
    <!-- End Content -->

    <!-- Start Brands -->
    <section class="bg-light py-5">
        <div class="container my-4">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Nuestros patrocinadores</h1>
                    <p>
                        Presentamos las marcas que son promocionadas por parte de nosotros.
                    </p>
                </div>
                <div class="col-lg-9 m-auto tempaltemo-carousel">
                    <div class="row d-flex flex-row">
                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#templatemo-slide-brand" role="button" data-bs-slide="prev">
                                <i class="text-light fas fa-chevron-left"></i>
                            </a>
                        </div>
                        <!--End Controls-->

                        <!--Carousel Wrapper-->
                        <div class="col">
                            <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="templatemo-slide-brand" data-bs-ride="carousel">
                                <!--Slides-->
                                <div class="carousel-inner product-links-wap" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca1.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca2.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca3.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca4.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End First slide-->

                                    <!--Second slide-->
                                    <div class="carousel-item">
                                        <div class="row">
                                            <!-- <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca5.png" alt="Brand Logo"></a>
                                        </div> -->
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca6.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca7.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="assets/img/logos/marca8.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Third slide-->

                                </div>
                                <!--End Slides-->
                            </div>
                        </div>
                        <!--End Carousel Wrapper-->

                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#templatemo-slide-brand" role="button" data-bs-slide="next">
                                <i class="text-light fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Brands-->


    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">San Andrés</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            Av Gerardo Unger 5689 - Los Olivos - Lima
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="whatsapp://send?text=¡Hola!, mucho gusto 🤝, me interesa saber más información 🙂.&phone=+51 937 075 845">+51 937 075 845</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:jorgepomar10@gmail.com">jorgepomar10@gmail.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Productos</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="shop.php">Cementos</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Arenas</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Bloques</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Ladrillos</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Alambres</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Mallas</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Barras de acero</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Información</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Inicio</a></li>
                        <li><a class="text-decoration-none" href="about.html">Nosotros</a></li>
                        <li><a class="text-decoration-none" href="shop.php">Artículos</a></li>
                        <li><a class="text-decoration-none" href="contact.html">Contáctenos</a></li>
                        <li><a class="text-decoration-none" href="../vistas/login.html">Iniciar Sesión</a></li>
                    </ul>
                </div>

            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            Copyright &copy; 2022 <strong>|</strong> Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo3.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->

    <!-- Start Search -->
    <script>
        $(document).ready(function buscar() {
            $('#txtBuscar').keyup(function() {
                var nombres = $('.titulo');
                var buscando = $(this).val();
                for (var i = 0; i < nombres.length; i++) {
                    item = $(nombres[i]).html().toLowerCase();
                    for (var x = 0; x < item.length; x++) {
                        if (buscando.length == 0 || item.indexOf(buscando) > -1) {
                            $(nombres[i]).parents('.tarjetaGeneral').show();
                        } else {
                            $(nombres[i]).parents('.tarjetaGeneral').hide();
                        }
                    }
                }
                if (nombres.length == $('.tarjetaGeneral:hidden').length) {
                    $('#noResults').show();
                } else {
                    $('#noResults').hide();
                }
            });
        });
    </script>
    <!-- End Search -->

    <!-- <script>
        $(document).ready(function() {
            $(".articulo").click(function() {
                var articulo = $(".articulo").text();
                $("#txtBuscar").val(articulo);
                buscar()
            });
        });
    </script> -->
</body>

</html>