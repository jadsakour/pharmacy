@extends('layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير مبيعات الأقسام</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left"></i>تفصيل الأدوية المباعة من قسم معين في مدة زمنية معينة</h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="adv-table">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                                <thead>
                                    <tr>
                                        <th>اسم الدواء</th>
                                        <th>الشركةالمصنعة</th>
                                        <th class="numeric" style="width:400px">التركيب الكيميائي</th>
                                        <th class="numeric">الفواتير التي تم بيعه فيها</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs as $drug)
                                        <tr>
                                            <td>{{ $drug->name_arabic }}</td>
                                            <td>{{ $drug->company->name }}</td>
                                            <td class="numeric">{{ $drug->chemical_composition }}</td>
                                            <td>
                                                @foreach ($drug->invoices as $invoice)
                                                    <a href="{{ route('invoice.show', $invoice->id) }}" target="_blank">{{ $invoice->id }}</a>
                                                @endforeach
                                            </td>
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
