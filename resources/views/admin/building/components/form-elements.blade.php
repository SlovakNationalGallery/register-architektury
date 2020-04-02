<div class="form-group row align-items-center" :class="{'has-danger': errors.has('source_id'), 'has-success': fields.source_id && fields.source_id.valid }">
    <label for="source_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.source_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.source_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('source_id'), 'form-control-success': fields.source_id && fields.source_id.valid}" id="source_id" name="source_id" placeholder="{{ trans('admin.building.columns.source_id') }}">
        <div v-if="errors.has('source_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('source_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('location_street'), 'has-success': fields.location_street && fields.location_street.valid }">
    <label for="location_street" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.location_street') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.location_street" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('location_street'), 'form-control-success': fields.location_street && fields.location_street.valid}" id="location_street" name="location_street" placeholder="{{ trans('admin.building.columns.location_street') }}">
        <div v-if="errors.has('location_street')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('location_street') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('image_filename'), 'has-success': fields.image_filename && fields.image_filename.valid }">
    <label for="image_filename" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.image_filename') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.image_filename" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('image_filename'), 'form-control-success': fields.image_filename && fields.image_filename.valid}" id="image_filename" name="image_filename" placeholder="{{ trans('admin.building.columns.image_filename') }}">
        <div v-if="errors.has('image_filename')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('image_filename') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <label for="status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.status" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('status'), 'form-control-success': fields.status && fields.status.valid}" id="status" name="status" placeholder="{{ trans('admin.building.columns.status') }}">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('style'), 'has-success': fields.style && fields.style.valid }">
    <label for="style" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.style') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.style" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('style'), 'form-control-success': fields.style && fields.style.valid}" id="style" name="style" placeholder="{{ trans('admin.building.columns.style') }}">
        <div v-if="errors.has('style')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('style') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('decade'), 'has-success': fields.decade && fields.decade.valid }">
    <label for="decade" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.decade') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.decade" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('decade'), 'form-control-success': fields.decade && fields.decade.valid}" id="decade" name="decade" placeholder="{{ trans('admin.building.columns.decade') }}">
        <div v-if="errors.has('decade')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('decade') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_duration_dates'), 'has-success': fields.project_duration_dates && fields.project_duration_dates.valid }">
    <label for="project_duration_dates" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.project_duration_dates') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_duration_dates" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_duration_dates'), 'form-control-success': fields.project_duration_dates && fields.project_duration_dates.valid}" id="project_duration_dates" name="project_duration_dates" placeholder="{{ trans('admin.building.columns.project_duration_dates') }}">
        <div v-if="errors.has('project_duration_dates')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_duration_dates') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_start_dates'), 'has-success': fields.project_start_dates && fields.project_start_dates.valid }">
    <label for="project_start_dates" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.project_start_dates') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_start_dates" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_start_dates'), 'form-control-success': fields.project_start_dates && fields.project_start_dates.valid}" id="project_start_dates" name="project_start_dates" placeholder="{{ trans('admin.building.columns.project_start_dates') }}">
        <div v-if="errors.has('project_start_dates')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_start_dates') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('location_gps'), 'has-success': fields.location_gps && fields.location_gps.valid }">
    <label for="location_gps" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.location_gps') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.location_gps" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('location_gps'), 'form-control-success': fields.location_gps && fields.location_gps.valid}" id="location_gps" name="location_gps" placeholder="{{ trans('admin.building.columns.location_gps') }}">
        <div v-if="errors.has('location_gps')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('location_gps') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('location_district'), 'has-success': fields.location_district && fields.location_district.valid }">
    <label for="location_district" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.location_district') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.location_district" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('location_district'), 'form-control-success': fields.location_district && fields.location_district.valid}" id="location_district" name="location_district" placeholder="{{ trans('admin.building.columns.location_district') }}">
        <div v-if="errors.has('location_district')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('location_district') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.building.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('location_city'), 'has-success': fields.location_city && fields.location_city.valid }">
    <label for="location_city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.location_city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.location_city" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('location_city'), 'form-control-success': fields.location_city && fields.location_city.valid}" id="location_city" name="location_city" placeholder="{{ trans('admin.building.columns.location_city') }}">
        <div v-if="errors.has('location_city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('location_city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('builder_authority'), 'has-success': fields.builder_authority && fields.builder_authority.valid }">
    <label for="builder_authority" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.builder_authority') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.builder_authority" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('builder_authority'), 'form-control-success': fields.builder_authority && fields.builder_authority.valid}" id="builder_authority" name="builder_authority" placeholder="{{ trans('admin.building.columns.builder_authority') }}">
        <div v-if="errors.has('builder_authority')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('builder_authority') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('builder'), 'has-success': fields.builder && fields.builder.valid }">
    <label for="builder" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.builder') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.builder" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('builder'), 'form-control-success': fields.builder && fields.builder.valid}" id="builder" name="builder" placeholder="{{ trans('admin.building.columns.builder') }}">
        <div v-if="errors.has('builder')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('builder') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('architect_names'), 'has-success': fields.architect_names && fields.architect_names.valid }">
    <label for="architect_names" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.architect_names') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.architect_names" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('architect_names'), 'form-control-success': fields.architect_names && fields.architect_names.valid}" id="architect_names" name="architect_names" placeholder="{{ trans('admin.building.columns.architect_names') }}">
        <div v-if="errors.has('architect_names')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('architect_names') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('processed_date'), 'has-success': fields.processed_date && fields.processed_date.valid }">
    <label for="processed_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.processed_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.processed_date" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('processed_date'), 'form-control-success': fields.processed_date && fields.processed_date.valid}" id="processed_date" name="processed_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('processed_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('processed_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.description') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" v-validate="''" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title_alternatives'), 'has-success': fields.title_alternatives && fields.title_alternatives.valid }">
    <label for="title_alternatives" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.title_alternatives') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title_alternatives" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title_alternatives'), 'form-control-success': fields.title_alternatives && fields.title_alternatives.valid}" id="title_alternatives" name="title_alternatives" placeholder="{{ trans('admin.building.columns.title_alternatives') }}">
        <div v-if="errors.has('title_alternatives')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title_alternatives') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bibliography'), 'has-success': fields.bibliography && fields.bibliography.valid }">
    <label for="bibliography" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.building.columns.bibliography') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.bibliography" v-validate="''" id="bibliography" name="bibliography" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('bibliography')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bibliography') }}</div>
    </div>
</div>


