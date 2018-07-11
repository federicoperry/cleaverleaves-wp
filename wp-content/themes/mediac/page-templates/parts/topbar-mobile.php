<div class="topbar-mobile  hidden-lg hidden-md">
    <div class="active-mobile pull-left">
        <button data-toggle="offcanvas" class="btn btn-offcanvas btn-toggle-canvas offcanvas" type="button">
           <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="topbar-inner pull-left">
        <div class="active-mobile search-popup pull-left">
                     
        </div>
        <div class="active-mobile setting-popup pull-left">
           
            <div class="active-content">
                <?php if(has_nav_menu( 'topmenu' )){ ?>
                    <div class="pull-left">
                        <?php
                            $args = array(
                                'theme_location'  => 'topmenu',
                                'container_class' => '',
                                'menu_class'      => 'menu-topbar'
                            );
                            wp_nav_menu($args);
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        
    </div>
</div>
