@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" >
        <h3><i class="fa fa-angle-right"></i>إضافة دفعة</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> معلومات</h4>
                    <form class="form-horizontal style-form" action="{{ route('accountingOperation.store') }}" method="POST">
                    @csrf
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">النوع</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="accounting_type_id">
                                    @foreach($types as $types)
                                    <option value="{{ $types->id }}">{{ $types->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">السعر</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="amount" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <div class="form-group" dir="rtl">
                            <label class="col-sm-2 col-sm-2 control-label">التاريخ</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date" oninvalid="this.setCustomValidity('هذا الحقل إلزامي')" onchange="this.setCustomValidity('')"  required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme">إضافة دفعة</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
