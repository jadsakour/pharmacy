@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" dir="rtl">
        <h3><i class="fa fa-angle-right"></i>تعديل النوع</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i>معلومات النوع</h4>
                    <form action="{{ route('accountingType.update', $accounting_type->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">اسم النوع </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $accounting_type->name }}" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">تعديل</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>>
@endsection
