<?php
// List items
$listRows = array(
    array(
        'icon' => 'abstract-26',
        'color' => 'success',
        'title' => 'Project Briefing',
        'description' => 'Project Manager',
    ),
    array(
        'icon' => 'pencil',
        'color' => 'warning',
        'title' => 'Concept Design',
        'description' => 'Art Director'
    ),
    array(
        'icon' => 'message-text-2',
        'color' => 'primary',
        'title' => 'Functional Logics',
        'description' => 'Lead Developer'
    ),
    array(
        'icon' => 'disconnect',
        'color' => 'danger',
        'title' => 'Development',
        'description' => 'DevOps'
    ),
    array(
        'icon' => 'security-user',
        'color' => 'info',
        'title' => 'Testing',
        'description' => 'QA Managers'
    )
);
?>


<!--begin::List Widget 1-->
<div class="card {{ $class }}">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder text-dark">Tasks Overview</span>
            <span class="text-muted mt-1 fw-bold fs-7">Pending 10 tasks</span>
        </h3>

        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                {!! theme()->getIcon("category", "fs-2") !!}
            </button>
        {{ theme()->getView('partials/menus/_menu-1') }}
        <!--end::Menu-->
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-5">
    @foreach($listRows as $row)
        <!--begin::Item-->
            <div class="d-flex align-items-center {{ util()->putIf(next($listRows), 'mb-7') }}">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">
                    <span class="symbol-label bg-light-{{ $row['color'] }}">
                        {!! theme()->getIcon($row['icon'], "fs-2x svg-icon-" . $row['color']); !!}
                    </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Text-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-dark text-hover-primary fs-6 fw-bolder">{{ $row['title'] }}</a>

                    <span class="text-muted fw-bold">{{ $row['description'] }}</span>
                </div>
                <!--end::Text-->
            </div>
            <!--end::Item-->
        @endforeach
    </div>
    <!--end::Body-->
</div>
<!--end::List Widget 1-->
