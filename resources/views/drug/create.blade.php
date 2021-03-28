@extends('layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-right mr"></i>إضافة دواء</h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right mr"></i>معلومات الدواء</h4>
                    <form class="form-horizontal style-form" action="{{ route('drug.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group " dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الاسم العربي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name_arabic" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">الاسم الانكليزي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name_english" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">التركيبة الكيميائية</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" name="chemical_composition"></textarea>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">خجم العبوة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="volume_unit" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">عدد الوحدات</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>



                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">سعر المبيع للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_sell_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">السعر الصافي للعلبة</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="package_net_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">سعر المبيع للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_sell_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">السعر الصافي للظرف</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="unit_net_price" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">رقم الترخيص الخاص بالمنتج الدوائي</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="lic_palte" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الباركود المحلي</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="local_barcode" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الباركود</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="global_barcode" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>


                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">الشركة</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="company_id">
                                    @foreach($companies as $company)
                                    <option value="{{$company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الصنف</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الشكل</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="shape_id">
                                    @foreach($shapes as $shape)
                                    <option value="{{$shape->id }}">{{ $shape->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">عدد الوحدات</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="units_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">عدد العلب</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="packages_number" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ الانتاج</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="pro_date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">تاريخ انتهاء الصلاحية</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="exp_date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-theme">إضافة</button>
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
