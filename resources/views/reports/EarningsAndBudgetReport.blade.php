@extends('/layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير الأرباح والميزانية</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left"></i>هذا التقرير يقوم بعرض عمليات البيع وعمليات الشراء خلال مدة معينة </h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="adv-table">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th>مجموع المبيعات</th>
                                        <th>مجموع المدفوعات</th>
                                        <th>مجموع الديون</th>
                                        <th>صافي الربح</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="numeric">{{ $prices[0] }}</td>
                                        <td class="numeric">{{ $prices[2] }}</td>
                                        <td class="numeric">{{ $prices[1] }}</td>
                                        <td class="numeric">{{ $prices[0] - ($prices[2] + $prices[1]) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <!-- /content-panel -->
            </div>
            <!-- /col-lg-4 -->
        </div>
        <!-- /row -->
    </section>
    <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
@endsection
