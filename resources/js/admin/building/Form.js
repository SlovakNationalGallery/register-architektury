import AppForm from '../app-components/Form/AppForm';

Vue.component('building-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                source_id:  '' ,
                title:  '' ,
                title_alternatives:  '' ,
                description:  '' ,
                processed_date:  '' ,
                architect_names:  '' ,
                builder:  '' ,
                builder_authority:  '' ,
                location_city:  '' ,
                location_district:  '' ,
                location_street:  '' ,
                location_gps:  '' ,
                project_start_dates:  '' ,
                project_duration_dates:  '' ,
                decade:  '' ,
                style:  '' ,
                status:  '' ,
                image_filename:  '' ,
                bibliography:  '' ,
                
            }
        }
    }

});