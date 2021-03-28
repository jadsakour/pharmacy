@extends('layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير الشركات</h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left"></i>تفصيل خاص بالشركات </h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="adv-table">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                                <thead>
                                    <tr>
                                        <th>اسم الشركة</th>
                                        <th class="numeric" >رقم الهاتف</th>
                                        <th class="numeric">عدد الأدوية التابعة لهذه الشركة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $company->name }}</td>
                                            <td class="numeric">{{ $company->phone }}</td>
                                            <td class="numeric">
                                                @foreach ($company->drugs as $drug)
                                                    <div class="col-4">
                                                        اسم الدواء:
                                                        {{ $drug->name_arabic }}
                                                    </div>
                                                    <div class="col-4">
                                                        عدد العلب:
                                                        {{ $drug->repo->sum('packages_number') }}
                                                    </div>
                                                    <div class="col-4">
                                                        عدد الظروف:
                                                        {{ $drug->repo->sum('units_number') }}
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
