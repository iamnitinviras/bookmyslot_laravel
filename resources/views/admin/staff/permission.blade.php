<?php
$permission = [];
if (old('permission') && old('permission') != null) {
    $permission = old('permission');
} else {
    if (isset($user->permissions) && $user->permissions->count() > 0) {
        $permission = $user->permissions->pluck('name')->toArray();
    }
}
?>
<!-- members Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.members.menu') }}</h6>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_show"
                    value="show members" onchange="check_permission(this)"
                    @if (in_array('show members', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_add"
                    value="add members" onchange="check_permission(this)"
                    @if (in_array('add members', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_edit"
                    value="edit members" onchange="check_permission(this)"
                    @if (in_array('edit members', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_delete"
                    value="delete members" onchange="check_permission(this)"
                    @if (in_array('delete members', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<!-- members trial Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.members.trial') }}</h6>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_trial_show"
                       value="show members_trial" onchange="check_permission(this)"
                @if (in_array('show members_trial', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_trial_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_trial_add"
                       value="add members_trial" onchange="check_permission(this)"
                @if (in_array('add members_trial', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_trial_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_trial_edit"
                       value="edit members_trial" onchange="check_permission(this)"
                @if (in_array('edit members_trial', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_trial_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_trial_delete"
                       value="delete members_trial" onchange="check_permission(this)"
                @if (in_array('delete members_trial', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_trial_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>


<!-- members enquiry Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.members.enquiry') }}</h6>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_enquiry_show"
                       value="show members_enquiry" onchange="check_permission(this)"
                @if (in_array('show members_enquiry', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_enquiry_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="members_enquiry_add"
                       value="add members_enquiry" onchange="check_permission(this)"
                @if (in_array('add members_enquiry', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_enquiry_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_enquiry_edit"
                       value="edit members_enquiry" onchange="check_permission(this)"
                @if (in_array('edit members_enquiry', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_enquiry_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="members_enquiry_delete"
                       value="delete members_enquiry" onchange="check_permission(this)"
                @if (in_array('delete members_enquiry', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="members_enquiry_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<!-- branch Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.branch.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="branch_show"
                       value="show branch" onchange="check_permission(this)"
                @if (in_array('show branch', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="branch_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="branch_add"
                       value="add branch" onchange="check_permission(this)"
                @if (in_array('add branch', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="branch_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="branch_edit"
                       value="edit branch" onchange="check_permission(this)"
                @if (in_array('edit branch', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="branch_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="branch_delete"
                       value="delete branch" onchange="check_permission(this)"
                @if (in_array('delete branch', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="branch_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h6>{{ __('system.packages.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="packages_show"
                       value="show packages" onchange="check_permission(this)"
                @if (in_array('show packages', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="packages_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="packages_add"
                       value="add packages" onchange="check_permission(this)"
                @if (in_array('add packages', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="packages_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="packages_edit"
                       value="edit packages" onchange="check_permission(this)"
                @if (in_array('edit packages', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="packages_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="packages_delete"
                       value="delete packages" onchange="check_permission(this)"
                @if (in_array('delete packages', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="packages_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<!-- staff Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.staffs.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_show"
                    value="show staff" onchange="check_permission(this)"
                    @if (in_array('show staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_add"
                    value="add staff" onchange="check_permission(this)"
                    @if (in_array('add staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_edit"
                    value="edit staff" onchange="check_permission(this)"
                    @if (in_array('edit staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_delete"
                    value="delete staff" onchange="check_permission(this)"
                    @if (in_array('delete staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>




<!-- report Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.reports.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="sales_report_show"
                       value="show sales_report" onchange="check_permission(this)"
                @if (in_array('show sales_report', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="sales_report_show">
                    {{ __('system.reports.sales_report') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="expiry_report_add"
                       value="add expiry_report" onchange="check_permission(this)"
                @if (in_array('add expiry_report', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="expiry_report_add">
                    {{ __('system.reports.expiry_report') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="collection_report_add"
                       value="add collection_report" onchange="check_permission(this)"
                @if (in_array('add collection_report', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="collection_report_add">
                    {{ __('system.reports.collection_report') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="balance_report_add"
                       value="add balance_report" onchange="check_permission(this)"
                @if (in_array('add balance_report', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="balance_report_add">
                    {{ __('system.reports.balance_report') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="attendance_report_add"
                       value="add attendance_report" onchange="check_permission(this)"
                @if (in_array('add attendance_report', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="attendance_report_add">
                    {{ __('system.reports.attendance_report') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="pending_payments_add"
                       value="add pending_payments" onchange="check_permission(this)"
                @if (in_array('add pending_payments', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="pending_payments_add">
                    {{ __('system.reports.pending_payments_report') }}
                </label>
            </div>
        </div>
    </div>


</div>

<div class="row">
    @error('permission')
        <div class="pristine-error text-help">{{ $message }}</div>
    @enderror
</div>
