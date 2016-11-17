<?php require_once 'header.php'; ?>

<!---- start-slider---->
<div class="slider">
    <!--End-top-nav---->
    <!---start-da-slider----->
    <div id="da-slider" class="da-slider">
    <div class="da-slide">
        <label><span> </span></label>
        <h2>ONLY BOLD AND CLEAN IDEAS</h2>
        <p>FOR OUR CLIENTS WITH LOVE</p>
        <i><a href="#"> </a></i>
        <small><a href="#">scroll to see the entire site</a></small>
    </div>
    <div class="da-slide">
        <label><span> </span></label>
        <h2>ONLY BOLD AND CLEAN IDEAS</h2>
        <p>FOR OUR CLIENTS WITH LOVE</p>
        <i><a href="#"> </a></i>
        <small><a href="#">scroll to see the entire site</a></small>
    </div>
    <div class="da-slide">
        <label><span> </span></label>
        <h2>ONLY BOLD AND CLEAN IDEAS</h2>
        <p>FOR OUR CLIENTS WITH LOVE</p>
        <i><a href="#"> </a></i>
        <small><a href="#">scroll to see the entire site</a></small>
    </div>
    <nav class="da-arrows">
        <span class="da-arrows-prev"></span>
        <span class="da-arrows-next"></span>
    </nav>
</div>
<script type="text/javascript" src="js/jquery.cslider.js"></script>
<script type="text/javascript">
    $(function() {

        $('#da-slider').cslider({
            autoplay	: true,
            bgincrement	: 450
        });

    });
</script>
    <!---//End-da-slider----->
</div>
<!---- //End-slider---->
<!---start-works---->
<!---image-hover-effects---->
 <script src="js/hover.zoom.js"></script>
              <script>
                $(function() {
                    $('.pink').hoverZoom({
                        overlay: true, // false to turn off (default true)
                        overlayColor: '#51A3C8', // overlay background color
                        overlayOpacity: 0.7, // overlay opacity
                        zoom: 0, // amount to zoom (px)
                        speed: 300 // speed of the hover
                    });


                });
            </script>
<!---//image-hover-effects---->
<div class="works" id="work">
    <div class="wrap">
        <div class="head">
            <span> </span>
            <h3>Les Recettes des Chefs</h3>
        </div>
        <!---start-mfp ---->
<div id="small-dialog1" class="mfp-hide">
    <div class="pop_up">
        <p class="para">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.</p>
    </div>
</div>
<!---end-mfp ---->

<!---//End-works---->
<!----start-about---->
<div class="about" id="about">
    <div class="wrap">
        <div class="head">
            <span> </span>
            <h3>Les + populaires </h3>
        </div>
        <div class="about-grids">
            <div class="about-grids">
            <div class="about-grid">
                <h3>Pizza italienne</h3>
   <img alt="Une pizza" src="http://www.formation-pizza-marketing.com/wp-content/uploads/2014/01/pizza-malbouffe-plat-equilibre2.jpg">
                <p>Lire la recette.</p>
            </div>

            <div class="about-grid">
                <h3>Riz frit au boeuf</h3>
   <img alt="riz" src="http://assets.kraftfoods.com/recipe_images/opendeploy/97866_MXM_K52406V1_OR1_CR_640x428.jpg">
                <p>Lire la recette.</p>
            </div>

            <div class="about-grid">
                <h3>Pâtes au curry</h3>
   <img alt="pâtes au curry" src="http://le-calice.com/wp-content/uploads/2015/10/pates2.jpg">
                <p>Lire la recette.</p>
            </div>

            <div class="clear"> </div>
        </div>
            <div class="clear"> </div>
        </div>
        <div class="clear"> </div>
    </div>
</div>
<!----//End-about---->
<!----start-services---->
<div class="services" id="services">
    <div class="wrap">
        <div class="head">
            <span> </span>
            <h3>Découvrir toutes les recettes des autres chefs !</h3>
        </div>

</div>
<!----//End-services---->
<!---start-purches-it---->
<div class="purches-it">
    <a href="shortcodes.html">Toutes vos recettes !</a>
</div>
<!---//End-purches-it---->
<!--- start-latest-news---->
<div class="latest-news" id="news">
    <div class="wrap">
        <div class="head">
            <span> </span>
            <h3>Les derniers ajouts</h3>
        </div>
        <!----news-grid-scroller---->
        <script type="text/javascript" src="js/jquery.flexisel.js"></script>
        <script type="text/javascript">
        $(window).load(function() {
            $("#flexiselDemo3").flexisel({
                visibleItems: 3,
                animationSpeed: 1000,
                autoPlay: true,
                autoPlaySpeed: 3000,
                pauseOnHover: true,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: {
                    portrait: {
                        changePoint:480,
                        visibleItems: 1
                    },
                    landscape: {
                        changePoint:640,
                        visibleItems: 2
                    },
                    tablet: {
                        changePoint:768,
                        visibleItems: 3
                    }
                }
            });
        });
        </script>
        <ul id="flexiselDemo3">
            <li>
                <div class="latest-news-grid">
                    <h3>19/<span>09</span></h3>
                    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSWG7BZmWiUFAl7T0X-eiSwVDPg_n6CEkiHqXXmAW7pSwQhZ1Mxqw" style="max-width:244.8px;max-height:115.5px;">
                </div>
            </li>
            <li>
                <div class="latest-news-grid">
                    <h3>12/<span>09</span></h3>
                    <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTqUgsB13gNWt6UicxmdfRCpQifMlcvI_K2254N_QqdlEr9R_GB" style="max-width:244.8px;max-height:115.5px;">
                </div>
            </li>
            <li>
                <div class="latest-news-grid">
                    <h3>23/<span>08</span></h3>
                    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSPP3PMYopk8Rss0ajKPzY0wnthwSjY-6cuKR5sNZK-zs6b9XJZ" style="max-width:244.8px;max-height:115.5px;">
                </div>
            </li>
            <li>
                <div class="latest-news-grid">
                    <h3>10/<span>08</span></h3>
                    <img src="http://venusendirect.free.fr/miam!/b6866a7e-5ef5-42d3-814d-1e3e4c62aacb_Choucroute.jpg" style="max-width:244.8px;max-height:115.5px;">
                </div>
            </li>
        </ul>
        <div class="clear"> </div>
        <!----//news-grid-scroller---->
        <!----latest-news-bottom-border---->
        <div class="bottom-border">
            <span> </span>
        </div>
        <!----//latest-news-bottom-border---->
    </div>
</div>
<!--- //End-latest-news---->
<?php require_once 'footer.php'; ?>
