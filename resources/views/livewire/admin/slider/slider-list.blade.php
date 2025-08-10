<div>
    <div class="card">
        <div class="card-body">
            <div class="table overflow-auto" tabindex="8">
                <div class="d-flex justify-content-end mb-2">
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-outline-info">افزودن</a>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">عنوان جستجو</label>
                    <div class="col-sm-10">
                        <input type="text"  class="form-control text-left" dir="rtl" wire:model.live="search">
                    </div>

                </div>
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle text-primary">ردیف</th>
                        <th class="text-center align-middle text-primary">عکس</th>
                        <th class="text-center align-middle text-primary">لینک</th>
                        <th class="text-center align-middle text-primary">وضعیت</th>
                        <th class="text-center align-middle text-primary">ویرایش</th>
                        <th class="text-center align-middle text-primary">حذف</th>
                        <th class="text-center align-middle text-primary">تاریخ ایجاد</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-center align-middle">
                                <figure class="avatar avatar">
                                    <img src="{{ asset('sliders/' . $slider->image) }}" class="rounded-circle" alt="image">
                                </figure>
                            </td>
                            <td class="text-center align-middle">{{ $slider->link }}</td>
                            <td class="text-center align-middle">
                                @if($slider->status)
                                <span class="cursor-pointer badge badge-success" wire:click="changeStatus('{{ $slider->id }}')">فعال</span>
                                @else
                                <span class="cursor-pointer badge badge-danger" wire:click="changeStatus('{{ $slider->id }}')">غیر فعال</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a class="btn btn-outline-info" href="{{ route('admin.sliders.edit', $slider->id) }}">
                                    ویرایش
                                </a>
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-outline-danger" wire:click="deleteConfirm('{{ $slider->id }}')">
                                    حذف
                                </button>
                            </td>
                            <td class="text-center align-middle">{{ verta($slider->created_at) }}</td>
                        </tr>
                        @endforeach
                </table>
                <div style="margin: 40px !important;" class="pagination pagination-rounded pagination-sm d-flex justify-content-center">
                    {{ $sliders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('deleteSlider', (message,type) => {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: "این عملیات قابل بازگشت نیست!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله حذف کن',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete',{id: message.sliderId});
                    }
                })
            })
        })
    </script>
@endsection
