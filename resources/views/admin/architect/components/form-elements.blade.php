<div class="form-group row align-items-center" :class="{'has-danger': errors.has('source_id'), 'has-success': fields.source_id && fields.source_id.valid }">
    <label for="source_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.source_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.source_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('source_id'), 'form-control-success': fields.source_id && fields.source_id.valid}" id="source_id" name="source_id" placeholder="{{ trans('admin.architect.columns.source_id') }}">
        <div v-if="errors.has('source_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('source_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.architect.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('last_name'), 'has-success': fields.last_name && fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.last_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': fields.last_name && fields.last_name.valid}" id="last_name" name="last_name" placeholder="{{ trans('admin.architect.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('last_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('birth_date'), 'has-success': fields.birth_date && fields.birth_date.valid }">
    <label for="birth_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.birth_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.birth_date" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('birth_date'), 'form-control-success': fields.birth_date && fields.birth_date.valid}" id="birth_date" name="birth_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('birth_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('birth_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('birth_place'), 'has-success': fields.birth_place && fields.birth_place.valid }">
    <label for="birth_place" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.birth_place') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.birth_place" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('birth_place'), 'form-control-success': fields.birth_place && fields.birth_place.valid}" id="birth_place" name="birth_place" placeholder="{{ trans('admin.architect.columns.birth_place') }}">
        <div v-if="errors.has('birth_place')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('birth_place') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('death_date'), 'has-success': fields.death_date && fields.death_date.valid }">
    <label for="death_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.death_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.death_date" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('death_date'), 'form-control-success': fields.death_date && fields.death_date.valid}" id="death_date" name="death_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('death_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('death_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('death_place'), 'has-success': fields.death_place && fields.death_place.valid }">
    <label for="death_place" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.death_place') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.death_place" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('death_place'), 'form-control-success': fields.death_place && fields.death_place.valid}" id="death_place" name="death_place" placeholder="{{ trans('admin.architect.columns.death_place') }}">
        <div v-if="errors.has('death_place')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('death_place') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bio'), 'has-success': fields.bio && fields.bio.valid }">
    <label for="bio" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.architect.columns.bio') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.bio" v-validate="''" id="bio" name="bio" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('bio')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bio') }}</div>
    </div>
</div>


