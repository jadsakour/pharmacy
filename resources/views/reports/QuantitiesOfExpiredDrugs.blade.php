@extends('/layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>كميات الأدوية المنتهية الصلاحية</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"> <i class="fa fa-angle-left"></i>كميات الأدوية المنتهية الصلاحية</h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="adv-table">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                                <thead>
                                    <tr>
                                        <th>اسم الدواء</th>
                                        <th>الشركةالمصنعة</th>
                                        <th class="numeric">تاريخ انتهاء الصلاحية</th>
                                        <th class="numeric" >الفترة المتبقية</th>
                                        <th class="numeric">عدد العلب</th>
                                        <th class="numeric">عدد الظروف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs as $drug)
                                        <tr>
                                            <td>{{ $drug->drug->name_arabic }}</td>
                                            <td>{{ $drug->drug->company->name }}</td>
                                            <td class="numeric">{{ $drug->exp_date }}</td>
                                            <td class="numeric">{{ (new DateTime(date('Y-m-d', strtotime(date('Y-m-d', strtotime($drug->exp_date))))))->diff(new DateTime(date('Y-m-d', strtotime("+$months months", strtotime(date('Y-m-d'))))))->format('%m شهر %d يوم') }}</td>
                                            <td class="numeric">{{ $drug->packages_number }}</td>
                                            <td class="numeric">{{ $drug->units_number }}</td>
                                        </tr>
                                    @endforeach
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
