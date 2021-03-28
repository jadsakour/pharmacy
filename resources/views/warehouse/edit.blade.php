@extends('/layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" dir="rtl">
        <h3><i class="fa fa-angle-right"></i>تعديل مستودع</h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i>معلومات المستودع</h4>
                    <form action="{{route('warehouse.update', $warehouse->id )}}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">اسم المستودع</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" value="{{ $warehouse->name }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">عنوان المستودع</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="address" value="{{ $warehouse->address }}"oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">رقم التواصل</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="phone" value="{{ $warehouse->phone }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">موعد الزيارة الأسبوعي</label>
                            <div class="col-sm-4">
                              <select class="form-control" name="weekly_date" >

                                <option value="السبت"><strong>السبت</strong></option>
                                <option value="الأحد"><strong>الأحد</strong></option>
                                <option value="الإثنين"><strong>الإثنين</strong></option>
                                <option value="الثلاثاء"><strong>الثلاثاء</strong></option>
                                <option value="الأربعاء"><strong>الأربعاء</strong></option>
                                <option value="الخميس"><strong>الخميس</strong></option>

                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">البريد الالكتروني</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="email" value="{{ $warehouse->email }}" oninvalid="this.setCustomValidity('رجاء إدخال عنوان بريد إلكتروني صحيحي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                            <label class="col-sm-2 col-sm-2 control-label">الفاكس</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="fax" value="{{ $warehouse->fax }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-theme">إضافة مستودع</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
