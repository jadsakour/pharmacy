<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="Dashboard" />
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina" />
        <title>برنامج إدارة الصيدليات</title>

        <!-- Favicons -->
        <link href="/img/favicon.png" rel="icon">
        <link href="/img/apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="/fonts/Droid Sans Arabic.ttf" />
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!--external css-->
        <link href="/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!--datatable-->
        <link rel="stylesheet" type="text/css" href="/lib/advanced-datatable/css/demo_page.css" />
        <link rel="stylesheet" type="text/css" href="/lib/advanced-datatable/css/demo_table.css" />
        <link rel="stylesheet" type="text/css" href="/lib/advanced-datatable/css/DT_bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="/lib/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="/lib/bootstrap-daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="/lib/colorpicker/css/colorpicker.css" />
        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/css/style-responsive.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- js placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="/lib/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.rtlcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/lib/jquery.dcjqaccordion.2.7.js"></script>
        <script type="text/javascript" src="/lib/jquery.scrollTo.min.js"></script>
        <script type="text/javascript" src="/lib/jquery.nicescroll.js"></script>
        <script type="text/javascript" language="javascript" src="/lib/advanced-datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="/lib/advanced-datatable/js/DT_bootstrap.js"></script>
        <!--script for this page-->
        <script type="text/javascript" src="/lib/jquery-ui-1.9.2.custom.min.js"></script>
        <!--custom switch-->
        <script type="text/javascript" src="/lib/bootstrap-switch.js"></script>
        <!--custom tagsinput-->
        <script type="text/javascript" src="/lib/jquery.tagsinput.js"></script>
        <!--custom checkbox & radio-->
        <script type="text/javascript" src="/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="/lib/bootstrap-daterangepicker/date.js"></script>
        <script type="text/javascript" src="/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script type="text/javascript" src="/lib/colorpicker/js/colorpicker.js"></script>
        <script type="text/javascript" src="/lib/form-component.js"></script>

        <!-- Custom Scripts -->
        @yield('custom-css')
    </head>
    <body dir="rtl">
        @include('layouts.header')
        <section id="container">
            @yield('content')
        </section>
        @include('layouts.footer')
        <!-- Custom Scripts -->
        @yield('scripts')
        <!--common script for all pages-->
        <script type="text/javascript" src="/lib/common-scripts.js"></script>
        <script type="text/javascript">
            /* Formating function for row details */
            function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
            sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
            sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
            sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
            sOut += '</table>';
            return sOut;
            }
            $(document).ready(function() {
                /*
                * Initialse DataTables, with no sorting on the 'details' column
                */
                if ($('#hidden-table-info tr').length > 2){
                    var oTable = $('#hidden-table-info').dataTable({
                        "aoColumnDefs": [{
                            "bSortable": false,
                            "aTargets": [0]
                        }],
                        "aaSorting": [
                            [1, 'asc']
                        ]
                    });
                }
                /* Add event listener for opening and closing details
                * Note that the indicator for showing which row is open is not controlled by DataTables,
                * rather it is done here
                */
                $('#hidden-table-info tbody td img').on('click', function() {
                    var nTr = $(this).parents('tr')[0];
                    if (oTable.fnIsOpen(nTr)) {
                        /* This row is already open - close it */
                        oTable.fnClose(nTr);
                    } else {
                        /* Open this row */
                        oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
                    }
                });
            });
        </script>
        <script>
            function printFunction() {
                window.print();
            }
        </script>
    </body>
</html>
