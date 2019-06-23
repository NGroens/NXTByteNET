<!-- Core  -->
<script src="<?php echo $cdnUrl; ?>vendor/babel-external-helpers/babel-external-helpers.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/jquery/jquery.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/popper-js/umd/popper.min.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/bootstrap/bootstrap.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/animsition/animsition.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/asscrollbar/jquery-asScrollbar.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/asscrollable/jquery-asScrollable.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="<?php echo $cdnUrl; ?>vendor/switchery/switchery.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/intro-js/intro.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/screenfull/screenfull.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-scroller/dataTables.scroller.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons/buttons.html5.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons/buttons.flash.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons/buttons.print.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons/buttons.colVis.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/asrange/jquery-asRange.min.js"></script>
<script src="<?php echo $cdnUrl; ?>vendor/bootbox/bootbox.js"></script>

<script>
    $('#desc_table').DataTable( {
        "order": [[0,"desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    } );
</script>
<script>
    $('#asc_table').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    } );
</script>
<script>
    $('#ticket_table').DataTable( {
        "order": [[2,"desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    } );
</script>

<!-- Scripts -->
<script src="<?php echo $cdnUrl; ?>js/Component.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Base.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Config.js"></script>

<script src="<?php echo $cdnUrl; ?>js/Section/Menubar.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Section/Sidebar.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Section/PageAside.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/menu.js"></script>

<!-- Config -->
<script src="<?php echo $cdnUrl; ?>js/config/colors.js"></script>
<script src="<?php echo $cdnUrl; ?>js/config/tour.js"></script>
<script>Config.set('assets', '../assets/style/');</script>

<!-- Page -->
<script src="<?php echo $cdnUrl; ?>js/Site.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/asscrollable.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/slidepanel.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/switchery.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/jquery-placeholder.js"></script>
<script src="<?php echo $cdnUrl; ?>js/Plugin/material.js"></script>

<script src="<?php echo $cdnUrl; ?>js/Plugin/datatables.js"></script>
<script src="<?php echo $cdnUrl; ?>examples/js/tables/datatable.js"></script>

<script>
    (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
            Site.run();
        });
    })(document, window, jQuery);
</script>
</body>
</html>