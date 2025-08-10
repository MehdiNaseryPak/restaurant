<div class="navigation">
    <div class="navigation-icon-menu">
        <ul>
            <li data-toggle="tooltip" title="اسلایدر">
                <a href="#sliders" title="اسلایدر">
                    <i class="icon ti-image"></i>
                </a>
            </li>
        </ul>
        <ul>
            <li data-toggle="tooltip" title="ویرایش پروفایل">
                <a href="#" class="go-to-page">
                    <i class="icon ti-settings"></i>
                </a>
            </li>
            <li data-toggle="tooltip" title="خروج">
                <a href="login.html" class="go-to-page">
                    <i class="icon ti-power-off"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navigation-menu-body">
        <ul id="sliders">
            <li>
                <a href="javascript:void(0)">اسلایدر</a>
                <ul>
                    <li><a href="{{ route('admin.sliders.create') }}">ایجاد اسلایدر</a></li>
                    <li><a href="{{ route('admin.sliders.index') }}">لیست اسلایدر ها</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
