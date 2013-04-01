<?php include_once('classes/login.class.php'); ?>
<?php include_once('header.php'); ?>

  <body>
<div id="login_page"> 
  <!-- Login page -->
  <div id="login">
    <div class="row-fluid fluid">
      <div class="span5">  </div>
      <div class="span7">
        <div class="title">
          <span class="name"></span>
          <span class="subtitle"></span>
        </div>
        <form class="form-search row-fluid "  action="login.php" method="post" >
          <div class="input-append row-fluid fluid">
            <input  class="place-right" id="username" name="username" maxlength="15" type="text"  placeholder="Kullanıcı adı"/><br><br>
           <input class="place-right" id="password" name="password" size="30" type="password" placeholder="Parola"/><br><br>

           <input type="hidden" name="token" value="<?php echo $_SESSION['jigowatt']['token']; ?>"/>
                
			<input type="checkbox" id="remember" name="remember"/><span ><?php _e(' Beni Hatırla !'); ?></span><br><br>
	
		<input type="submit" value="<?php _e(' Giriş '); ?>" class=" btn " id="login-submit" name="login"/>
                 
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End #login --> 
  <!-- <img src="img/ajax-loader.gif"> --> 
</div>
<!-- End #loading --> 

<!-- Le javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<!-- Flip effect on login screen --> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> 
<script type="text/javascript" src="js/plugins/jquerypp.custom.js"></script> 
<script type="text/javascript" src="js/plugins/jquery.bookblock.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script> 
<script type="text/javascript">
      $(function() {
        var Page = (function() {

          var config = {
              $bookBlock: $( '#bb-bookblock' ),
              $navNext  : $( '#bb-nav-next' ),
              $navPrev  : $( '#bb-nav-prev' ),
              $navJump  : $( '#bb-nav-jump' ),
              bb        : $( '#bb-bookblock' ).bookblock( {
                speed       : 800,
                shadowSides : 0.8,
                shadowFlip  : 0.7
              } )
            },
            init = function() {

              initEvents();
              
            },
            initEvents = function() {

              var $slides = config.$bookBlock.children(),
                  totalSlides = $slides.length;

              // add navigation events
              config.$navNext.on( 'click', function() {
              $("#arrow_register").fadeOut();
              $(".not-member").slideUp();
              $(".already-member").slideDown();
                config.bb.next();
                return false;

              } );

              config.$navPrev.on( 'click', function() {

                 $(".not-member").slideDown();
                $(".already-member").slideUp();
                config.bb.prev();
                return false;

              } );

              config.$navJump.on( 'click', function() {
                
                config.bb.jump( totalSlides );
                return false;

              } );
              
              // add swipe events
              $slides.on( {

                'swipeleft'   : function( event ) {
                
                  config.bb.next();
                  return false;

                },
                'swiperight'  : function( event ) {
                
                  config.bb.prev();
                  return false;
                  
                }

              } );

            };

            return { init : init };

        })();

        Page.init();

      });
    </script> 
<script type='text/javascript'>
 
    $(window).load(function() {
     $('#loading1').fadeOut();
    });
      $(document).ready(function() {
           $("input:checkbox, input:radio, input:file").uniform();


      $('[rel=tooltip]').tooltip();
      $('body').css('display', 'none');
      $('body').fadeIn(500);

      $("#logo a, #sidebar_menu a:not(.accordion-toggle), a.ajx").click(function() {
        event.preventDefault();
        newLocation = this.href;
        $('body').fadeOut(500, newpage);
        });
        function newpage() {
        window.location = newLocation;
        }
      });
      
    

    </script>
</body>
</html>
            
