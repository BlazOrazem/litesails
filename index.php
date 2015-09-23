<?php include('header.php'); ?>

<?php include('nav.php'); ?>

<div class="container">

    <div class="row">
        <div class="col-lg-12" id="content">

            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="active"><a href="#today" data-toggle="tab"><span class="area"></span> Today</a></li>
                <li><a href="#tomorrow" data-toggle="tab"><span class="area"></span> Tomorrow</a></li>
                <li><a href="#after" data-toggle="tab"><span class="area"></span> Day After tomorrow</a></li>
            </ul>

            <div class="tab-content" data-source="<?php echo(isset($_GET['map']) ? $_GET['map'] : 'split');  ?>">
                <div class="tab-pane active" id="today">
                    <nav class="text-center">
                        <ul class="pagination aladin-hour">
                            <li><a href="#" data-value="03">03</a></li>
                            <li><a href="#" data-value="06">06</a></li>
                            <li><a href="#" data-value="09">09</a></li>
                            <li><a href="#" data-value="12">12</a></li>
                            <li><a href="#" data-value="15">15</a></li>
                            <li><a href="#" data-value="18">18</a></li>
                            <li><a href="#" data-value="21">21</a></li>
                            <li><a href="#" data-value="24">00</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="tab-pane" id="tomorrow">
                    <nav class="text-center">
                        <ul class="pagination aladin-hour">
                            <li><a href="#" data-value="27">03</a></li>
                            <li><a href="#" data-value="30">06</a></li>
                            <li><a href="#" data-value="33">09</a></li>
                            <li><a href="#" data-value="36">12</a></li>
                            <li><a href="#" data-value="39">15</a></li>
                            <li><a href="#" data-value="42">18</a></li>
                            <li><a href="#" data-value="45">21</a></li>
                            <li><a href="#" data-value="48">00</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="tab-pane" id="after">
                    <nav class="text-center">
                        <ul class="pagination aladin-hour">
                            <li><a href="#" data-value="51">03</a></li>
                            <li><a href="#" data-value="54">06</a></li>
                            <li><a href="#" data-value="57">09</a></li>
                            <li><a href="#" data-value="60">12</a></li>
                            <li><a href="#" data-value="63">15</a></li>
                            <li><a href="#" data-value="66">18</a></li>
                            <li><a href="#" data-value="69">21</a></li>
                            <li><a href="#" data-value="72">00</a></li>
                        </ul>
                    </nav>
                </div>
                <img src="images/sailboat.gif" id="aladin-image" class="img-responsive center-block">
            </div>

        </div>
    </div>

</div>

<?php include('footer.php'); ?>