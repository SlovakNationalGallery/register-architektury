import AppForm from '../app-components/Form/AppForm';

Vue.component('image-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                source_id:  '' ,
                building_id:  '' ,
                title:  '' ,
                author:  '' ,
                created_date:  '' ,
                source:  '' ,
                
            }
        }
    }

});