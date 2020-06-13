<?php
$title = "Accueil";
$userrole = "Standard User"; // Allow only logged in users
include "login/misc/pagehead.php";
$uid = $_SESSION['uid'];
$_SESSION['monuid'] = $_SESSION['uid'];
$usr = PHPLogin\UserHandler::pullUserById($uid);
$_SESSION['adminMail'] = $conf->admin_email;
$_SESSION['userMail'] = $usr['email'];
$profil = PHPLogin\ProfileData::pullAllUserInfo($uid);
$_SESSION['FirstName'] = $profil['FirstName'];
$_SESSION['Phone'] = $profil['Phone'];
$_SESSION['typeClient'] = $usr['typeClient'];
$_SESSION['LastName'] = $profil['LastName'];
include './login/dbconf.php';

$connect = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
</head>
<body>
    <div class="" id="main-wrapper">
        <?php
        if ($auth->isLoggedIn()) {

            include "includes/topbar.php";
            include "includes/sidebar.php";
            //require 'login/misc/pullnav.php';
            ?>


            <?php
        } else {
            echo '<div class="jumbotron text-center"><h1 class="display-1">Homepage</h1>
    <small>This is your homepage. You are currently signed out.</small><br><br>
    <p>You can sign in or create a new account by clicking "Sign In" in the top right corner!</p>';
        }
        ?>
        <div class="page-wrapper">
            <div class="page-titles">
                <div class="d-flex align-items-center">
                    <h5 class="font-medium m-b-0"><?php echo $title; ?></h5>
                </div>
            </div>
            <?php if ($auth->isSuperAdmin() || $auth->isAdmin()): ?>
                <div class="container-fluid">
                    <div class="row">
                         <div class="col l3 m6 s12">
                            <div class="card primary-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <?php
                                        $sqltotalDevis = "SELECT count(*) as totalDevis  FROM commandes where  encours=1";
                                        if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $sqltotalDevis .=" and id_client='".$_GET['client']."'";
                                        }
                                        $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                        $stmttotalDevis->execute();
                                        $objtotalDevis = $stmttotalDevis->fetchObject();
                                        ?>
                                        <div>
                                            <h2 class="white-text m-b-5"><?php echo $objtotalDevis->totalDevis; ?></h2>
                                            <h6 class="white-text op-5 light-blue-text">Commande Validées</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">check_box</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col l3 m6 s12">
                            <div class="card gris-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <?php
                                        $sqltotalDevis = "SELECT count(*) as totalDevis  FROM commandes where  encours=0";
                                        if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $sqltotalDevis .=" and id_client='".$_GET['client']."'";
                                        }
                                        $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                        $stmttotalDevis->execute();
                                        $objtotalDevis = $stmttotalDevis->fetchObject();
                                        ?>
                                        <div>
                                            <h2 class="white-text m-b-5"><?php echo $objtotalDevis->totalDevis; ?></h2>
                                            <h6 class="white-text op-5">Devis en cours</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">assignment</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col l3 m6 s12">
                            <div class="card success-gradient card-hover">
                                <?php
                                $adminId="10506784655e29c755d9458";
                                        $sqltotalDeviss = "SELECT count(*) as usermembers  FROM usermembers ";
                                        if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $sqltotalDeviss .=" where id='".$_GET['client']."'";
                                        }
                                        $stmttotalDevis = $connect->prepare($sqltotalDeviss);
                                        $stmttotalDevis->execute();
                                        $objtotalDevis = $stmttotalDevis->fetchObject();
                                        ?>
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h2 class="white-text m-b-5"><?php echo $objtotalDevis->usermembers; ?></h2>
                                            <h6 class="white-text op-5 text-darken-2">Clients</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">supervisor_account</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="col l3 m6 s12">
                            <div class="card warning-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <?php
                                            $sqltotalDevis = "SELECT sum(REPLACE(recaPrixVal, ',', '')) as recaPrixVal  FROM commandes where encours=1";
                                             if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $sqltotalDevis .=" and id_client='".$_GET['client']."'";
                                        }
                                            $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                            $stmttotalDevis->execute();
                                            $objtotalDevis = $stmttotalDevis->fetchObject();
                                            ?>
                                            <h2 class="white-text m-b-5"><?php echo number_format($objtotalDevis->recaPrixVal, 2, ',', ''); ?></h2>
                                            <h6 class="white-text op-5">Montant</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">euro_symbol</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col s12 l12">
                            <div class="card">
                                <div class="card-content">
                                    <!--<a href="devis.php" class="waves-effect waves-light btn btn-round orange right">Créez un devis</a> --> 
                                    <h4 class="card-title">COMMANDES</h4>
                                    <h6 class="card-subtitle"><!--Vous avez créé 15 devis et 0 commandes.--></h6>
                                    <div class="row">
                                        <div class="col s12 l6">
                                        Afficher &nbsp;
                                            <div class="input-field inline">
                                                <select id="demo-show-entries">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            &nbsp; Projets
                                        </div>
                                    </div>
                                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="5">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true"> Client final  </th>
                                                <th> Projet </th>
                                                <th data-hide="phone">  Référence de projet  </th>
                                                <th data-hide="number">  Prix  </th>
                                                <th data-hide="">  Devis </th>
                                                <th data-hide="phone">  Status </th>
                                                <th data-hide="phone">  Action </th>
                                                <th data-hide="all"> Date </th>
                                                <th data-hide="all"> Forme </th>
                                                <th data-hide="all"> Périmètre </th>
                                                <th data-hide="all"> Tissu </th>
                                                <th data-hide="all"> Couleur </th>
                                                <th data-hide="all"> Sangle </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $statement = "SELECT * FROM commandes ";
                                           if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $statement .=" where id_client='".$_GET['client']."' ";
                                        }
                                        $statement .=" order by id desc";
                                        $statement=$connect->prepare($statement);
                                            $statement->execute();
                                            $result = $statement->fetchAll();
                                            foreach ($result as $row) {

                                                $sqlGetName = "SELECT perimetre, tissu, couleurTissus, sangle, forme  FROM details_cmd where id='" . $row['id_cmd'] . "'";
                                                if(isset($_GET['client']) && !empty($_GET['client'])){
                                            $sqlGetName .=" and id_client='".$_GET['client']."'";
                                        }
                                                $stmtGetName = $connect->prepare($sqlGetName);
                                                $stmtGetName->execute();
                                                $objGetName = $stmtGetName->fetchObject();
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['client_final']; ?></td>
                                                    <td><?php echo $row['projet']; ?></td>
                                                    <td><?php echo $row['ref_projet']; ?></td>
                                                    <td><?php echo $row['recaPrixVal']; ?></td>
                                                     <td><a href="<?php if(isset($row['pdf'])  && !empty($row['pdf'])){echo substr($row['pdf'], 4);} else {echo "javascript:void(0);";} ?>" class="blue-text "  title="Télécharger le devis"><i class="small material-icons">file_download</i></a></td>
                                                    <td><?php
                                                        if ($row['encours'] == 1) {
                                                            echo '<span class="label label-table label-success ">Commande Validée</span>';
                                                        }
                                                       elseif ($row['etat'] == 0) {
                                                            echo '<span class="label label-table orange ">Devis en cours</span>';
                                                        }
                                                        else {
                                                            echo '<span class="label label-table label-red ">Commande envoyée</span>';
                                                        }
                                                        
                                                        ?></td>

                                                    <td class="">
                                                   <?php if($row['encours']==0){ ?>     <a href="#" class="green-text validerDevis"  title="Valider le devis" rel="<?php echo $row['id']."-".$row['id_cmd']."-".$row['encours'];?>"><i class="small material-icons">check_box</i></a><?php }?> <a href="#" class="red-text deleteDevis" title="Supprimer" rel="<?php echo $row['id']."-".$row['id_cmd'];?>"><i class="small material-icons ">delete_forever</i></a></td>
                                                    <td><?php echo $row['date_add']; ?></td>
                                                    <td><?php echo $objGetName->forme." angles"; ?></td>
                                                    <td><?php echo $objGetName->perimetre." m"; ?></td>
                                                    <td><?php echo getNom("tissus", $objGetName->tissu, "nom"); ?></td>
                                                    <td><?php echo getNom("couleur", $objGetName->couleurTissus, "nom"); ?></td>
                                                    <td><?php echo $objGetName->sangle; ?></td>
                                                    

                                                </tr>
                                                <?php
                                            }
                                            unset($statement);
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div></div></div>
                </div>
            <script>
        
        $(document).on('click', '.validerDevis', function () {
                var id = $(this).attr('rel');
                Swal({
                    title: "<h6 class='text-danger'><b>êtes-vous sûr de vouloir valider ce devis?</b></h6>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui!',
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: "includes/ajax/valide_devis.php",
                                method: "POST",
                                data: {id: id},
                                dataType: 'json',
                                success: function (data)
                                {
                                    swal({
        title: data.success,
        type : "success",
        confirmButtonColor: "#A5DC86",
        timer: 3000
}).then(function(){ 
        location.reload();
});
                                    //location.reload();
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    swal("Error deleting!", "Please try again", "error");
                                }
                            });
                        });
                    },
                    allowOutsideClick: false
                });
            });
        </script>
            <?php endif; ?>
            <?php if (!$auth->isSuperAdmin() && !$auth->isAdmin()): ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col l4 m6 s12">
                            <div class="card primary-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <?php
                                        $sqltotalDevis = "SELECT count(*) as totalDevis  FROM commandes where id_client='" . $uid . "' AND encours=1";
                                        $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                        $stmttotalDevis->execute();
                                        $objtotalDevis = $stmttotalDevis->fetchObject();
                                        ?>
                                        <div>
                                            <h2 class="white-text m-b-5"><?php echo $objtotalDevis->totalDevis; ?></h2>
                                            <h6 class="white-text op-5 light-blue-text">Commande Validées</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">assignment</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col l4 m6 s12">
                            <div class="card gris-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <?php
                                            $sqltotalDevis = "SELECT count(*) as totalDevis  FROM commandes where id_client='" . $uid . "' AND encours=0";
                                            $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                            $stmttotalDevis->execute();
                                            $objtotalDevis = $stmttotalDevis->fetchObject();
                                            ?>
                                            <h2 class="white-text m-b-5"><?php echo $objtotalDevis->totalDevis; ?></h2>
                                            <h6 class="white-text op-5">Devis encours</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">receipt</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col l4 m6 s12">
                            <div class="card warning-gradient card-hover">
                                <div class="card-content">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <?php
                                            $sqltotalDevis = "SELECT sum(REPLACE(recaPrixVal, ',', '')) as recaPrixVal  FROM commandes where id_client='" . $uid . "' AND encours=1";
                                            $stmttotalDevis = $connect->prepare($sqltotalDevis);
                                            $stmttotalDevis->execute();
                                            $objtotalDevis = $stmttotalDevis->fetchObject();
                                            ?>
                                            <h2 class="white-text m-b-5"><?php echo number_format($objtotalDevis->recaPrixVal, 2, ',', ''); ?></h2>
                                            <h6 class="white-text op-5">Montant</h6>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="white-text display-6"><i class="material-icons">euro_symbol</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col s12 l12">
                            <div class="card">
                                <div class="card-content">
                                    <a href="devis.php" class="waves-effect waves-light btn btn-round orange right">Créez un devis</a>
                                    <h4 class="card-title">COMMANDES</h4>
                                    <h6 class="card-subtitle"><!--Vous avez créé 15 devis et 0 commandes.--></h6>
                                    <div class="row">
                                        <div class="col s12 l6">
                                            Afficher &nbsp;
                                            <div class="input-field inline">
                                                <select id="demo-show-entries">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            &nbsp; projets
                                        </div>
                                    </div>
                                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="5">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true"> Client final  </th>
                                                <th> Projet </th>
                                                <th data-hide="">  Référence de projet  </th>
                                                <th data-hide="">  Prix  </th>
                                                <th data-hide="">  Devis </th>
                                                <th data-hide="phone">  Status </th>
                                                <th data-hide="phone">  Action </th>
                                                <th data-hide="all"> Date </th>
                                                <th data-hide="all"> Forme </th>
                                                <th data-hide="all"> Périmètre </th>
                                                <th data-hide="all"> Tissu </th>
                                                <th data-hide="all"> Couleur </th>
                                                <th data-hide="all"> Sangle </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $statement = $connect->prepare("SELECT * FROM commandes where id_client='".$uid."'  order by id desc");
                                            $statement->execute();
                                            $result = $statement->fetchAll();
                                            foreach ($result as $row) {

                                                $sqlGetName = "SELECT perimetre, tissu, couleurTissus, sangle, forme  FROM details_cmd where id='" . $row['id_cmd'] . "'";
                                                $stmtGetName = $connect->prepare($sqlGetName);
                                                $stmtGetName->execute();
                                                $objGetName = $stmtGetName->fetchObject();
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['client_final']; ?></td>
                                                    <td><?php echo $row['projet']; ?></td>
                                                    <td><?php echo $row['ref_projet']; ?></td>
                                                    <td><?php echo $row['recaPrixVal']; ?></td>
                                                    <td><a href="<?php if(isset($row['pdf'])  && !empty($row['pdf'])){echo substr($row['pdf'], 4);} else {echo "javascript:void(0);";} ?>" class="blue-text " title="Télécharger le devis"><i class="small material-icons">file_download</i></a></td>
                                                    <td><?php
                                                        if ($row['encours'] == 1) {
                                                            echo '<span class="label label-table label-success ">Commande Validée</span>';
                                                        } elseif ($row['etat'] == 0) {
                                                            echo '<span class="label label-table orange ">Devis en cours</span>';
                                                        }
                                                        else {
                                                            echo '<span class="label label-table label-red ">Commande envoyée</span>';
                                                        }
                                                        
                                                        ?></td>

                                                    <td class="right" style="width: 130px;">
                                                   <?php  if(isset($row['encours']) && $row['encours']==0){ ?>     <a href="devis_edit.php?idDevis=<?php echo $row['id']."-".$row['id_cmd'];?>"><i class="small material-icons" title="Modifier">edit</i></a> <?php }?><a href="#" class="black-text copyDevis" title="Dupliquer" rel="<?php echo $row['id']."-".$row['id_cmd']."-".$row['projet'];?>"><i class="small material-icons">content_copy</i></a> <a href="#" class="red-text deleteDevis" title="Supprimer" rel="<?php echo $row['id']."-".$row['id_cmd'];?>"><i class="small material-icons ">delete_forever</i></a></td>
                                                    <td><?php echo $row['date_add']; ?></td>
                                                    <td><?php echo $objGetName->forme." angles"; ?></td>
                                                    <td><?php echo $objGetName->perimetre." m"; ?></td>
                                                    <td><?php echo getNom("tissus", $objGetName->tissu, "nom"); ?></td>
                                                    <td><?php echo getNom("couleur", $objGetName->couleurTissus, "nom"); ?></td>
                                                    <td><?php echo $objGetName->sangle; ?></td>
                                                    <td><?php echo getNom("materiels", $objGetName->connecteur, "nom"); ?></td>
                                                    <td><?php echo getNom("materiels", $objGetName->tendeur, "nom"); ?></td>
                                                    <td><?php echo getNom("materiels", $objGetName->fixation, "nom"); ?></td>

                                                </tr>
                                                <?php
                                            }
                                            unset($statement);
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-split m-t-30"> </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div></div></div>
                </div>
            <script>
        $('.copyDevis').on('click', function (event) {
        var id = $(this).attr('rel');
           Swal({
                    title: "<h6 class='text-info'><b>êtes-vous sûr de vouloir dupliquer ce devis?</b></h6>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui!',
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: "includes/ajax/devis/copy_devis.php",
                                method: "POST",
                                data: {id: id},
                                success: function (data)
                                {
                                    swal({
        title: data.success,
        type : "success",
        confirmButtonColor: "#A5DC86",
        timer: 3000
}).then(function(){ 
        location.reload();
});
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    swal("Impossbile de dupliquer le devis!", "Please try again", "error");
                                }
                            });
                        });
                    },
                    allowOutsideClick: false
                });
        
    });
        </script>
        <?php endif; ?>
        <?php include "includes/footer.php"; ?>
        </div>
    <?php include "includes/rightbar.php"; ?>
    </div>
    <?php
    function getNom($dbTable, $idValue, $nomreturn) {
        include './login/dbconf.php';
        $connect = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlGetName = "SELECT " . $nomreturn . " as nom  FROM " . $dbTable . " where id='" . $idValue . "'";
        $stmtGetName = $connect->prepare($sqlGetName);
        $stmtGetName->execute();
        $objGetName = $stmtGetName->fetchObject();
        if(isset($objGetName->nom)){
        return $objGetName->nom;
        }
    }
    ?>
    <script>
        $(document).on('click', '.deleteDevis', function () {
                var id = $(this).attr('rel');
                Swal({
                    title: "<h6 class='text-danger'><b>êtes-vous sûr de vouloir supprimer le devis?</b></h6>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui!',
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: "includes/ajax/devis/delete_devis.php",
                                method: "POST",
                                data: {id: id},
                                success: function (data)
                                {
                                    swal({
        title: data.success,
        type : "success",
        confirmButtonColor: "#A5DC86",
        timer: 3000
}).then(function(){ 
        location.reload();
});
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    swal("Error deleting!", "Please try again", "error");
                                }
                            });
                        });
                    },
                    allowOutsideClick: false
                });
            });
        
        </script>
</body>
</html>
