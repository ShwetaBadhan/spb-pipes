@extends('admin.layout.master')
@section('content')
    <!-- ========================
               Start Page Content
              ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                </script>
            @endif
            <!-- start row -->
            <div class="row justify-content-center">

                <div class="col-xl-12">

                    <!-- start row -->
                    <div class="row settings-wrapper d-flex">

                        <!-- Start settings sidebar -->

                        <div class="col-xl-3 col-lg-4">
                        @include('admin.components.settings-sidebar')
                          
                        </div><!-- end col -->

                        <!-- End settings sidebar -->

                        <!-- Make sure to pass $settings from controller to this view -->

    <div class="col-xl-9 col-lg-8">
        <div class="mb-3 pb-3 border-bottom">
            <h6 class="fw-bold mb-0">Localization</h6>
        </div>
        <form action="{{ route('localization-settings.update') }}" method="POST">
    @csrf
        <div class="d-flex align-items-center mb-3">
            <span class="p-1 rounded-2 bg-dark text-white d-inline-flex align-items-center justify-content-center me-2"><i class="isax isax-info-circle"></i></span>
            <h6 class="fw-semibold fs-16 mb-0 d-inline-flex align-items-center">Basic Information</h6>
        </div>
        <div class="row align-items-center row-gap-3 mb-3">
            <!-- Time Zone -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Time Zone<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="time_zone">
                        <option value="(+5:30) GMT" {{ isset($settings) && $settings->time_zone == '(+5:30) GMT' ? 'selected' : '' }}>(+5:30) GMT</option>
                        <option value="(GMT -10:00) Hawaii" {{ isset($settings) && $settings->time_zone == '(GMT -10:00) Hawaii' ? 'selected' : '' }}>(GMT -10:00) Hawaii</option>
                        <option value="(GMT -9:30) Taiohae" {{ isset($settings) && $settings->time_zone == '(GMT -9:30) Taiohae' ? 'selected' : '' }}>(GMT -9:30) Taiohae</option>
                        <option value="(GMT -9:00) Alaska" {{ isset($settings) && $settings->time_zone == '(GMT -9:00) Alaska' ? 'selected' : '' }}>(GMT -9:00) Alaska</option>
                        <option value="(GMT -8:00) Pacific Time, Canada" {{ isset($settings) && $settings->time_zone == '(GMT -8:00) Pacific Time, Canada' ? 'selected' : '' }}>(GMT -8:00) Pacific Time, Canada</option>
                    </select>
                </div>
            </div>

            <!-- Start Week On -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Start Week On<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="start_week">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}" {{ isset($settings) && $settings->start_week == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date Format -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Date Format<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="date_format">
                        <option value="18 Mar 2025" {{ isset($settings) && $settings->date_format == '18 Mar 2025' ? 'selected' : '' }}>18 Mar 2025</option>
                        <option value="Mar 18 2025" {{ isset($settings) && $settings->date_format == 'Mar 18 2025' ? 'selected' : '' }}>Mar 18 2025</option>
                        <option value="2025 Mar 18" {{ isset($settings) && $settings->date_format == '2025 Mar 18' ? 'selected' : '' }}>2025 Mar 18</option>
                    </select>
                </div>
            </div>

            <!-- Time Format -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Time Format<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="time_format">
                        <option value="12 hrs" {{ isset($settings) && $settings->time_format == '12 hrs' ? 'selected' : '' }}>12 hrs</option>
                        <option value="24hrs" {{ isset($settings) && $settings->time_format == '24hrs' ? 'selected' : '' }}>24hrs</option>
                    </select>
                </div>
            </div>

            <!-- Default Language -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Default Language<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="default_language">
                        @foreach(['English', 'German', 'Arabic', 'French'] as $lang)
                            <option value="{{ $lang }}" {{ isset($settings) && $settings->default_language == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Language Switcher -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Language Switcher<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <div class="form-check form-switch ps-0">
                        <!-- Added name and checked logic -->
                        <input class="form-check-input m-0" type="checkbox" name="language_switcher" value="1" {{ isset($settings) && $settings->language_switcher ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <!-- Currency Section Header -->
            <div class="col-md-12">
                <div class="border-top mt-2 pt-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="p-1 rounded-2 bg-dark text-white d-inline-flex align-items-center justify-content-center me-2"><i class="isax isax-dollar-square"></i></span>
                        <h5 class="fw-semibold fs-16 mb-0 d-inline-flex align-items-center">Currency Information</h5>
                    </div>
                </div>
            </div>

            <!-- Currency -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Currency<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="currency">
                        @foreach(['USD', 'Dollar', 'Euro', 'Pound', 'Rupee'] as $curr)
                            <option value="{{ $curr }}" {{ isset($settings) && $settings->currency == $curr ? 'selected' : '' }}>{{ $curr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

           <!-- Currency Symbol -->
<div class="col-xl-9 col-sm-7">
    <div class="setting-info">
        <h6 class="fs-14 fw-medium mb-0">Currency Symbol <span class="text-danger ms-1">*</span></h6>
    </div>
</div>
<div class="col-xl-3 col-sm-5 float-sm-end">
    <div>
        <select class="select" name="currency_symbol" id="currency_symbol">
            @foreach(['$', '₹', '£', '€'] as $sym)
                <option value="{{ $sym }}" {{ isset($settings) && $settings->currency_symbol == $sym ? 'selected' : '' }}>{{ $sym }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Currency Position -->
<div class="col-xl-9 col-sm-7">
    <div class="setting-info">
        <h6 class="fs-14 fw-medium mb-0">Currency Position<span class="text-danger ms-1">*</span></h6>
    </div>
</div>
<div class="col-xl-3 col-sm-5 float-sm-end">
    <div>
        <select class="select" name="currency_position" id="currency_position">
            @php
                $symbol = isset($settings) ? $settings->currency_symbol : '$';
                $positions = [
                    $symbol . '100',
                    '100' . $symbol,
                    $symbol . ' 100',
                    '100 ' . $symbol
                ];
            @endphp
            @foreach($positions as $pos)
                <option value="{{ $pos }}" {{ isset($settings) && $settings->currency_position == $pos ? 'selected' : '' }}>{{ $pos }}</option>
            @endforeach
        </select>
    </div>
</div>

            <!-- Decimal Separator -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Decimal Separator<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select" name="decimal_separator">
                        <option value="." {{ isset($settings) && $settings->decimal_separator == '.' ? 'selected' : '' }}>.</option>
                        <option value="," {{ isset($settings) && $settings->decimal_separator == ',' ? 'selected' : '' }}>,</option>
                    </select>
                </div>
            </div>

            <!-- Thousand Separator -->
            <div class="col-xl-9 col-sm-7">
                <div class="setting-info">
                    <h6 class="fs-14 fw-medium mb-0">Thousand Separator<span class="text-danger ms-1">*</span></h6>
                </div>
            </div>
            <div class="col-xl-3 col-sm-5 float-sm-end">
                <div>
                    <select class="select lh-2" name="thousand_separator">
                        <option value="." {{ isset($settings) && $settings->thousand_separator == '.' ? 'selected' : '' }}>.</option>
                        <option value="," {{ isset($settings) && $settings->thousand_separator == ',' ? 'selected' : '' }}>,</option>
                        <option value="'" {{ isset($settings) && $settings->thousand_separator == "'" ? 'selected' : '' }}>'</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between settings-bottom-btn mt-0 border-top pt-3">
            <button type="button" class="btn btn-outline-white btn-md me-2">Cancel</button>
            <button type="submit" class="btn btn-primary btn-md">Save Changes</button>
        </div>
        </form>
    </div>

                    </div>
                    <!-- end row -->

                </div><!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- End Content -->


    </div>

    <!-- ========================
               End Page Content
              ========================= -->
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const symbolSelect = document.getElementById('currency_symbol');
    const positionSelect = document.getElementById('currency_position');
    
    // Store the current selected position value
    let currentPositionValue = positionSelect.value;
    
    function updateCurrencyPositions() {
        const symbol = symbolSelect.value;
        const positions = [
            symbol + '100',
            '100' + symbol,
            symbol + ' 100',
            '100 ' + symbol
        ];
        
        // Clear existing options
        positionSelect.innerHTML = '';
        
        // Add new options
        positions.forEach(function(pos) {
            const option = document.createElement('option');
            option.value = pos;
            option.textContent = pos;
            
            // Restore previously selected value if it matches the new format
            if (pos === currentPositionValue) {
                option.selected = true;
            }
            
            positionSelect.appendChild(option);
        });
        
        // Update the stored position value
        currentPositionValue = positionSelect.value;
    }
    
    // Listen for changes on currency symbol
    symbolSelect.addEventListener('change', function() {
        updateCurrencyPositions();
    });
    
    // Store position value before form submit to maintain selection
    positionSelect.addEventListener('change', function() {
        currentPositionValue = this.value;
    });
});
</script>
    
@endpush