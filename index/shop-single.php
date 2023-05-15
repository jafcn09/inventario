<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistema de Inventario | Detalles</title>
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

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
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
</style>

<?php include('../config/Conexion.php');
$sql = "SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,ve.correo,ve.telefono,u.nombre as usuario,ae.nombre as articulo,ae.medida as medida,ae.material as material,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen WHERE idventaexterna='" . $_GET['id'] . "'";
$data = $conexion->query($sql);
$result = $data->fetch_assoc();
?>

<?php include('../config/Conexion.php');
$sql = "SELECT ve.idventaexterna,ve.correo,ve.telefono,ve.descripcion,u.nombre as usuario,ae.nombre as articulo,ae.imagen as imagen,c.nombre as categoria,a.ubicacion as almacen,ae.descripcion as precio,ae.idarticulo,ve.fecha_hora as fecha,ve.estado FROM venta_externa ve INNER JOIN usuario u ON ve.idusuario=u.idusuario INNER JOIN articulo_externo ae ON ve.idarticulo=ae.idarticulo INNER JOIN categoria c ON ae.idcategoria=c.idcategoria INNER JOIN almacen a ON ae.idalmacen=a.idalmacen ORDER BY RAND()";
$result2 = $conexion->query($sql);
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

    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="../files/articulos/<?php echo $result['imagen'] ?>" id="product-detail">
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"><?php echo ucwords(strtolower($result['articulo'])) ?></h1>
                            <p class="h3 py-2">S/. <?php echo $result['precio'] ?></p>
                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Categoría:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo ucwords(strtolower($result['categoria'])) ?></strong></p>
                                </li>
                            </ul>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Almacén:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo $result['almacen'] ?>.</strong></p>
                                </li>
                            </ul>

                            <h6>Descripción:</h6>
                            <p><?php echo $result['descripcion'] ?></p>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Medida:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo $result['medida'] ?>.</strong></p>
                                </li>
                            </ul>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Material:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo ucwords(strtolower($result['material'])) ?>.</strong></p>
                                </li>
                            </ul>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Fecha de publicación:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted">
                                        <strong>
                                            <?php setlocale(LC_TIME, 'spanish');
                                            $date = date_create();
                                            $newDate = strftime("%A, %d de %B del %G", strtotime($date->format($result['fecha'])));
                                            echo utf8_encode(ucfirst($newDate)); ?> a las <?php $fecha = $result['fecha'];
                                            $nuevaFecha = new DateTime($fecha);
                                            $fechaConvertida = $nuevaFecha->format("H:i:s a");
                                            echo $fechaConvertida;
                                            ?>.
                                        </strong>
                                    </p>
                                </li>
                            </ul>

                            <hr style="margin-top: 0;">

                            <h1 class="h2">Autor</h1>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Nombre:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo $result['usuario'] ?>.</strong></p>
                                </li>
                            </ul>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Correo:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo $result['correo'] ?>.</strong></p>
                                </li>
                            </ul>

                            <ul class="list-inline" style="margin: 0">
                                <li class="list-inline-item">
                                    <h6>Teléfono:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong><?php echo $result['telefono'] ?>.</strong></p>
                                </li>
                            </ul>

                            <div class="row pb-2">
                                <div class="col d-grid">
                                    <a class="btn btn-success btn-lg" href="whatsapp://send?text=¡Hola *<?php echo $result['usuario'] ?>*!, mucho gusto 🤝, me interesa saber más información de tu artículo *<?php echo ucwords(strtolower($result['articulo'])) ?>* 🙂.&phone=+51<?php echo $result['telefono'] ?>">Contactar</a>
                                </div>
                                <div class="col d-grid"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Comments -->
    <!-- <section class="py-5" style="background: #f9f9f9;">
        <div class="container my-4">
            <div id="disqus_thread"></div>
            <script>
                (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document,
                        s = d.createElement('script');
                    s.src = 'https://excavadora.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </section> -->
    <!-- End Comments -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Artículos relacionados</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">

                <?php
                foreach ($result2 as $row) {
                ?>
                    <div class="p-2 pb-3">
                        <div class="product-wap card rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" src="../files/articulos/<?php echo $row['imagen'] ?>" style="height: 180px;">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white mt-2" href="shop-single.php?id=<?php echo $row['idventaexterna'] ?>"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a class="h3 text-decoration-none titulo"><strong><?php echo ucwords(strtolower($row['articulo'])) ?> - <?php echo ucwords(strtolower($row['categoria'])) ?></strong></a>
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
                                        <?php echo ($row['estado'] == 'Activado') ? '<span class="label" style="background-color: #00a65a !important; font-size: 11px;">Disponible</span>' : '<span class="label" style="background-color: #dd4b39 !important; font-size: 11px;">Agotado</span>' ?>
                                    </li>
                                </ul>
                                <p class="text-center mb-0">S/. <?php echo $row['precio'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>


        </div>
    </section>
    <!-- End Article -->

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
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="assets/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>
    <!-- End Slider Script -->

</body>

</html>