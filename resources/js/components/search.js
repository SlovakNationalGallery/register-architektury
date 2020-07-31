global.Bloodhound = require('corejs-typeahead/dist/bloodhound.js');
require('corejs-typeahead/dist/typeahead.jquery.js');

var buildings = new Bloodhound({
  datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/objekty/suggest/?search=%QUERY',
    wildcard: '%QUERY',
    filter: function (buildings) {
            return $.map(buildings.results, function (item) {
                return {
                    id: item.id,
                    url: item.url,
                    title: item.title
                    // image: building.image,
                };
            });
        }
    }
});

var architects = new Bloodhound({
  datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/architekti/suggest/?search=%QUERY',
    wildcard: '%QUERY',
    filter: function (architects) {
            return $.map(architects.results, function (item) {
                return {
                    architect: item.architect,
                    value: item.architect
                };
            });
        }
    }
});


$("document").ready(function() {

  // $('#toggleSearch.not-initialized').on('click', function() {
  //     $(this).removeClass('not-initialized');
  // });

  buildings.initialize();
  architects.initialize();

  $search = $('#search');

  // $search.on('focus', function() {
  //     this.value = '';
  // });

  $search.typeahead(
  {
    hint: false,
    highlight: true,
    minLength: 2
  },
  {
    name: 'architects',
    displayKey: 'value',
    limit: 3,
    source: architects.ttAdapter(),
    templates: {
        header: '<h3 class="suggest-type-name my-0 pt-3 pb-1">' + $search.data('architects-title') + '</h3>',
        suggestion: function (data) {
          return '<div>'+data.value+'</div>';
        }
    }
  },
  {
    name: 'buildings',
    displayKey: 'value',
    limit: 4,
    source: buildings.ttAdapter(),
    templates: {
      header: '<h3 class="suggest-type-name my-0 pt-3 pb-1">'+ $search.data('buildings-title') +'</h3>',
      suggestion: function (data) {
          return '<div><img src="'+data.image+'" class="preview"><span class="m-preview"><span class="">' + data.architect + '</span>: ' + data.name + '</span></div>';
      }
    }
  });

});