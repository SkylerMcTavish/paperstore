<?php
  global $Visit;
?> 
<section class="wrapper" id='visit-info'>
    <div class="row">
        <!-- contact-widget -->
        <div class="col-lg-12">
            <div class="contact-widget contact-widget-info">
                <div class="panel-body">
                    <div class="col-lg-4 col-sm-4">
                        <h4> <?php echo $Visit->name ?></h4> 
                        <div class="row text-center">
                            <span class="contact-avatar" style="width:70px;">
                                <i class="fa fa-map-marker" style="font-size: 4em;"></i> &nbsp;&nbsp;
                            </span>
                        </div>
                        <div class="row">
                            <h6> <?php echo $Visit->pdv ?> </h6>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 follow-info">  
                        <p> &nbsp; </p>					
                    </div>
                    <div class="col-lg-4 col-sm-4 follow-info "> 					
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-heading tab-bg-info " style="padding-bottom: 0;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#visit-information" data-toggle="tab"> <i class="fa fa-info "></i> <span class='hidden-xs'>&nbsp;Información</span> </a>
                        </li> 
                        <li class="">
                            <a href="#visit_stock" data-toggle="tab" onclick="javascript: detail_stock(<?php echo $Visit->id_visit; ?>);"> <i class="fa fa-tag "></i> <span class='hidden-xs'>&nbsp;Stock</span> </a>
                        </li> 
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <!-- Info -->
                        <div class="tab-pane active" id="visit-information">
                            <section class="panel"> 
                                <div class="panel-body bio-graph-info">
                                    <h1 > Información </h1> 
                                    <div class="row ">
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">PDV </label> <?php echo $Visit->pdv; ?> &nbsp; </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">Usuario </label> <?php echo $Visit->user; ?> &nbsp; </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">Inicio Programado </label> <?php echo date("Y-m-d H:i:s", $Visit->scheduled_start); ?> &nbsp; </p>
                                        </div>
                                        <!--
                                        <div class="col-xs-12 col-sm-6">
                                                <p><label class="col-xs-4">Final Programado </label> <?php echo date("Y-m-d H:i:s", $Visit->scheduled_end); ?> &nbsp; </p>
                                        </div>
                                        -->
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">Inicio Real </label> <?php echo $Visit->real_start > 0 ? date("Y-m-d H:i:s", $Visit->real_start) : ""; ?> &nbsp; </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">Final Real </label> <?php echo $Visit->real_end > 0 ? date("Y-m-d H:i:s", $Visit->real_end) : ""; ?> &nbsp; </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p><label class="col-xs-4">Status:</label> <?php echo $Visit->visit_status; ?> &nbsp; </p>
                                        </div>

                                        <h2> Mapa </h2>			
                                        <div class="row "> 
                                            <div class="col-xs-6">
                                                <p><label class="col-xs-4">Latitud </label> <?php echo $Visit->latitude; ?> &nbsp; </p>
                                                <input type="hidden" id='det_visit_latitude' value='<?php echo $Visit->latitude; ?>' />
                                            </div>
                                            <div class="col-xs-6">
                                                <p><label class="col-xs-4">Longitud </label> <?php echo $Visit->longitude; ?> &nbsp; </p>
                                                <input type="hidden" id='det_visit_longitude' value='<?php echo $Visit->longitude; ?>' />
                                            </div>
                                        </div>
                                        <iframe src="views/visit/mapvisit.php?latitud=<?php echo floatval($Visit->latitude); ?>&longitud=<?php echo floatval($Visit->longitude); ?>&title=<?php echo $Visit->pdv; ?>" style="width: 100%;" height="450" frameborder="0" ></iframe>											

                                    </div>
                                </div>
                            </section> 											
                        </div>
                        <div class="tab-pane active" id="visit_stock">
                            <section class="panel"> 
                                <div class="panel-body bio-graph-info">
                                    <div class="row "> 
                                        <div class="col-xs-6 col-md-12">
                                            <table class="table table-striped table-bordered table-hover " id="tbl_stock">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>E. Actual</th>
                                                        <th>Anaquel</th> 
                                                        <th>Exhibición</th> 
                                                        <th>C. Totales</th> 
                                                        <th>Precio</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section> 											
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>