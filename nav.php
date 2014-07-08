<?php 
require_once('header.html');
?>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Helix</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse" style="width:100%;">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="popular.php">Popular</a></li>
                    <li><a href="new.php">New</a></li>
                </ul>
                <form class="navbar-form navbar-right" role="search" style="float:right;">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="bs-sidebar affix">
        <ul class="nav bs-sidenav">
            <li class="collapse"><a href="javascript:$('.nav-sub1').toggle();">Playlists<span class="caret"></span></a>
                <ul class="nav-sub1" style="display:none;list-style-type:none;">
                    <li class="subnav"><a href="#" style="width:100%;">Playlist1</a></li>
                    <li class="subnav"><a href="#" style="width:100%;">Playlist2</a></li>
                </ul>
            </li>
            <li class="collapse"><a href="javascript:$('.nav-sub2').toggle();">Following<span class="caret"></span></a></li>
            <ul class="nav-sub2" style="display:none;list-style-type:none;">
                <li class="subnav"><a href="#" style="width:100%;">Artist1</a></li>
                <li class="subnav"><a href="#" style="width:100%;">Artist2</a></li>
            </ul>
        </ul>
    </div>
    <div class="page_content">