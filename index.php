<?

    session_start();
    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $jsFiles = glob("js/*.js");
    $cssFiles = glob("css/*.css");
    $incFiles = glob("includes/*.php");
    
    foreach($incFiles as $inc){
        include($inc);
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Clicker</title>
        <?foreach($jsFiles as $js):?>
            <script src="<?=$js?>" type="text/javascript"></script>
        <?endforeach;?>
        <?foreach($cssFiles as $css):?>
            <link href="<?=$css?>" rel="stylesheet" />
        <?endforeach;?>
    </head>
    <body>
        
        <div id="wrap">
        
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">munsClicker</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <form class="navbar-form navbar-right" method="post" action="posts/login.php" >
                            <div class="form-group">
                                <input type="text" placeholder="Username" class="form-control" name="uname">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" class="form-control" name="passwd">
                            </div>
                            <button type="submit" class="btn btn-success" name="submit" value="login">Sign in</button>
                            <button type="submit" class="btn btn-info" name="submit" value="register">Register</button>
                        </form>
                    </div><!--/.navbar-collapse -->
                </div>
            </div>

            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>bitClicker</h1>
                            <h3>Welcome to my infiniclicker game</h3>
                            <h5><a class="clearData">Clear Data</a></h5>
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="clickArea">
                            <div class="row spacer">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="clickMe">
                                                <?=$btc?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul>
                                                <li class="curClicks">Current clicks: <span class="count">0</span></li>
                                                <li class="curCPS">Current clicks/second:<span class="count">0</span></li>
                                                <li></li>
                                                <li class="statusInfo"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 autoClickerList">
                        <h3>Autoclickers</h3><hr />
                        <?foreach($autoItems as $r):?>
                        <div class="row spacer autoClicker" data-id="<?=$r['id']?>" data-value="<?=$r['value']?>" data-inc="<?=$r['increase']?>" data-cost="<?=$r['cost']?>">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="name"><?=$r['name']?></span>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-4" style="text-align: right;">
                                        (costs:<span class="cost"><?=$r['cost']?></span>)
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="desc"><?=$r['desc']?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?endforeach;?>
                    </div>
                    <div class="col-md-4">
                        <h3>Upgrades</h3><hr />
                    </div>
                </div>
            </div>


            <div class="betaFlag">
                <span class="glyphicon glyphicon-star"></span>
                <span class="version">BETA</span>
                <span class="glyphicon glyphicon-star"></span>
            </div>
        </div>
    </body>
</html>
