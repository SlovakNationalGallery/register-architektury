const select2 = require('select2');

$(document).ready(function(){
    function formatState (state) {
      if (!state.id) {
         return state.text;
       }
      var  option_text =  state.text.replace(/ *\([^)]*\) */g, "");
      var  option_count =  state.text.match(/\((.*)\)/)[1];
      var $state = $(
          '<span>' + option_text + ' <span class="badge badge-pill badge-light">'+option_count+'</span></span>'
        );
      return $state;
    };

    $(".custom-select").select2({
      templateResult: formatState,
      templateSelection: formatState,
      theme: "bootstrap4",
      allowClear: true
    });

    $("#filters :input").change(function(e) {
        var form = $(this).closest("form");
        form.find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        form.submit();
    });
});