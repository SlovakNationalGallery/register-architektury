<div class="form-group row align-items-center" :class="{'has-danger': errors.has('source_id'), 'has-success': fields.source_id && fields.source_id.valid }">
    <label for="source_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.source_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.source_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('source_id'), 'form-control-success': fields.source_id && fields.source_id.valid}" id="source_id" name="source_id" placeholder="{{ trans('admin.image.columns.source_id') }}">
        <div v-if="errors.has('source_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('source_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('building_id'), 'has-success': fields.building_id && fields.building_id.valid }">
    <label for="building_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.building_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.building_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('building_id'), 'form-control-success': fields.building_id && fields.building_id.valid}" id="building_id" name="building_id" placeholder="{{ trans('admin.image.columns.building_id') }}">
        <div v-if="errors.has('building_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('building_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.image.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('author'), 'has-success': fields.author && fields.author.valid }">
    <label for="author" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.author') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.author" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('author'), 'form-control-success': fields.author && fields.author.valid}" id="author" name="author" placeholder="{{ trans('admin.image.columns.author') }}">
        <div v-if="errors.has('author')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('author') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('created_date'), 'has-success': fields.created_date && fields.created_date.valid }">
    <label for="created_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.created_date') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.created_date" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('created_date'), 'form-control-success': fields.created_date && fields.created_date.valid}" id="created_date" name="created_date" placeholder="{{ trans('admin.image.columns.created_date') }}">
        <div v-if="errors.has('created_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('created_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('source'), 'has-success': fields.source && fields.source.valid }">
    <label for="source" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.image.columns.source') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.source" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('source'), 'form-control-success': fields.source && fields.source.valid}" id="source" name="source" placeholder="{{ trans('admin.image.columns.source') }}">
        <div v-if="errors.has('source')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('source') }}</div>
    </div>
</div>


