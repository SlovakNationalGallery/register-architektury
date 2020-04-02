import AppForm from '../app-components/Form/AppForm';

Vue.component('architect-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                source_id:  '' ,
                first_name:  '' ,
                last_name:  '' ,
                birth_date:  '' ,
                birth_place:  '' ,
                death_date:  '' ,
                death_place:  '' ,
                bio:  '' ,
                
            }
        }
    }

});