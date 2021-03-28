@extends('layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right mr"></i>اختر نوع التقرير </h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <br>
                    <form class="form-horizontal style-form" action="{{ route('report.filter') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">نوع التقرير</label>
                            <div class="col-sm-10" id="styled-select">
                                <select class="form-control" name="type">
                                    <option value="1">تقرير الشركات</option>
                                    <option value="2">تقرير مبيعات الشركات</option>
                                    <option value="3">تقرير المبيعات اليومية</option>
                                    <option value="4">تقرير الميزانية والأرباح</option>
                                    <option value="5">تقرير المصاريف</option>
                                    <option value="6">تقرير المشتريات</option>
                                    <option value="7">تقرير كميات الأدوية منتهية الصلاحية</option>
                                    <option value="8">تقرير طلبيات المستودع</option>
                                    <option value="9">تقرير الأقسام</option>
                                    <option value="10">تقرير مبيعات الأقسام</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group optional referral" dir="rtl" style="display:none;">
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ البداية</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="start-date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')">
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ النهاية</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="end-date"oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')">
                            </div>
                        </div>

                        <div class="form-group categories" dir="rtl" style="display:none;">
                            <label class="col-sm-2 col-sm-2 control-label">اختر قسم</label>
                            <div class="col-sm-10" id="styled-select">
                                <select class="form-control" name="category">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group warehouses" dir="rtl" style="display:none;">
                            <label class="col-sm-2 col-sm-2 control-label">اختر مستودع</label>
                            <div class="col-sm-10" id="styled-select">
                                <select class="form-control" name="warehouse">
                                    <option value="0" selected></option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group months" dir="rtl" style="display:none;">
                            <label class="col-sm-2 col-sm-2 control-label">عدد الأشهر المتبقية</label>
                            <div class="col-sm-10" id="styled-select">
                                <input type="number" class="form-control" name="months" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">عرض التقرير</button>
                    </form>
                </div>
            </div>
            <!-- col-lg-12-->
        </div>
        <!-- /row -->
    </section>
    <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
@endsection
@section('scripts')
<script>
$("select").change(function () {
    // hide all optional elements
    $('.optional').css('display','none');
    $('.categories').css('display','none');
    $('.warehouses').css('display','none');
    $('.months').css('display','none');

    $("select option:selected").each(function () {
        if($(this).val() == "2"||$(this).val() == "4"||$(this).val() == "5"||$(this).val() == "6"||$(this).val() == "8") {
            $('.referral').css('display','block');
        }
        if($(this).val() == "9"||$(this).val() == "10") {
            $('.categories').css('display','block');
        }
        if($(this).val() == "7") {
            $('.months').css('display','block');
        }
        if($(this).val() == "8") {
            $('.warehouses').css('display','block');
        }
    });
});
</script>
@endsection
