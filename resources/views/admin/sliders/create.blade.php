@extends('admin.layouts.master')

@section('title', 'افزودن اسلایدر')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">
            <h6 class="card-title">ایجاد اسلایدر</h6>
            <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="image"> آپلود عکس </label>
                    <input  class="col-sm-10" name="image" type="file" class="form-control-file" id="image">
                </div>
                <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">لینک</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control text-right" placeholder="لینک" dir="ltr" name="link">
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">وضعیت</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control">
                            <option value="1">فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <button class="btn btn-success btn-uppercase">
                        <i class="ti-check-box m-r-5"></i> ذخیره
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
