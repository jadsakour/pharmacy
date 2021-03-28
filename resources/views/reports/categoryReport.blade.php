@extends('layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير الأقسام</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left "></i>مجموعة الأدوية التابعة ل قسم معين</h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="adv-table">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                                <thead>
                                    <tr>
                                        <th>اسم الدواء</th>
                                        <th>الشركةالمصنعة</th>
                                        <th class="numeric" style="width:400px">التركيب الكيميائي</th>
                                        <th class="numeric">تفاصيل الموجودات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs as $drug)
                                        <tr>
                                            <td>{{ $drug->name_arabic }}</td>
                                            <td>{{ $drug->company->name }}</td>
                                            <td class="numeric">{{ $drug->chemical_composition }}</td>
                                            <td>
                                                @foreach ($drug->repo()->where('isDisposed', '0')->get() as $drug_repo)
                                                    <div class="row">
                                                        <div class="col-4">{{ $drug_repo->exp_date }}</div>
                                                        <div class="col-4">{{ $drug_repo->packages_number }}</div>
                                                        <div class="col-4">{{ $drug_repo->units_number }}</div>
                                                    </div>
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
